<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Services\ResponseService;
use App\Services\TransactionService;
use Illuminate\Http\Request;

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

    public function store(TransactionRequest $request)
    {
        $data = $request->validated();

        $transaction = TransactionService::store($data);

        if ($transaction) {
            return new TransactionResource($transaction);
        }

        return ResponseService::fail();
    }

    public function show(int $transaction)
    {
        $transaction = TransactionService::get($transaction);

        if ($transaction) {
            return new TransactionResource($transaction);
        }

        return ResponseService::fail();

    }

    public function update(Request $request, Transaction $transaction)
    {
        return ResponseService::unavailable('update transaction');
    }

    public function destroy(Transaction $transaction)
    {
        return ResponseService::unavailable('delete transaction');
    }
}
