<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Services\PaymentService;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PaymentController extends Controller
{
    public function index()
    {
        if (!Gate::check('proceed')) {
            return ResponseService::unauthenticated();
        }

        $payments = PaymentService::all();

        if ($payments) {
            if (!$payments->count()) {
                return ResponseService::notFound('payment');
            }

            return PaymentResource::collection($payments);
        }

        return ResponseService::fail();
    }

    /**
     * @param PaymentRequest $request
     */
    public function store(PaymentRequest $request)
    {
        if (!Gate::check('proceed')) {
            return ResponseService::unauthenticated();
        }

        $data = $request->validated();

        $payment = PaymentService::store($data);

        if ($payment) {
            return new PaymentResource($payment);
        }

        return ResponseService::fail();
    }

    /**
     * @param int $payment
     */
    public function show(int $payment)
    {
        if (!Gate::check('proceed')) {
            return ResponseService::unauthenticated();
        }

        $payment = PaymentService::get($payment);

        if ($payment) {
            return new PaymentResource($payment);
        }

        return ResponseService::fail();
    }

    /**
     * @param Request $request
     * @param Payment $payment
     */
    public function update(Request $request, Payment $payment)
    {
        return ResponseService::unavailable('update payment');
    }

    /**
     * @param Payment $payment
     */
    public function destroy(Payment $payment)
    {
        return ResponseService::unavailable('delete payment');
    }
}
