<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Services\ResponseService;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = PaymentService::all();

        if ($payments) {
            if (!$payments->count()) {
                return ResponseService::notFound('payment');
            }

            return PaymentResource::collection($payments);
        }

        return ResponseService::fail();
    }

    public function store(PaymentRequest $request)
    {
        $data = $request->validated();

        $payment = PaymentService::store($data);

        if ($payment) {
            return new PaymentResource($payment);
        }

        return ResponseService::fail();
    }

    public function show(int $payment)
    {
        $payment = PaymentService::get($payment);

        if ($payment) {
            return new PaymentResource($payment);
        }

        return ResponseService::fail();

    }

    public function update(Request $request, Payment $payment)
    {
        return ResponseService::unavailable('update payment');
    }

    public function destroy(Payment $payment)
    {
        return ResponseService::unavailable('delete payment');
    }
}
