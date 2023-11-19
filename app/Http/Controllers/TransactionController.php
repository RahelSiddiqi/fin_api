<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Services\ResponseService;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = TransactionService::all();

        if ($transactions) {
            if (!$transactions->count()) {
                return ResponseService::notFound('transaction');
            }
            return TransactionResource::collection($transactions);
        }

        return ResponseService::fail();
    }

    /**
     * @param TransactionRequest $request
     */
    public function store(TransactionRequest $request)
    {
        if (!Gate::check('proceed')) {
            return ResponseService::unauthenticated();
        }

        $data = $request->validated();

        $transaction = TransactionService::store($data);

        if ($transaction) {
            return new TransactionResource($transaction);
        }

        return ResponseService::fail();
    }

    /**
     * @param int $transaction
     */
    public function show(int $transaction)
    {
        $transaction = TransactionService::get($transaction);

        if ($transaction) {
            return new TransactionResource($transaction);
        }

        return ResponseService::fail();
    }

    /**
     * @param Request $request
     * @param Transaction $transaction
     */
    public function update(Request $request, Transaction $transaction)
    {
        return ResponseService::unavailable('update transaction');
    }

    /**
     * @param Transaction $transaction
     */
    public function destroy(Transaction $transaction)
    {
        return ResponseService::unavailable('delete transaction');
    }
}
