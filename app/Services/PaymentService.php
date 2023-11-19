<?php

namespace App\Services;

use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class PaymentService implements ServiceInterface
{
    /**
     * @param array $data
     */
    public static function all(): Collection | null
    {
        $query = Payment::query();

        if (request('transaction_id')) {
            $query = $query->where('transaction_id', request('transaction_id'))
                    ->with('transaction');
        }

        if (request('transaction')) {
            $query = $query->with('transaction');
        }

        $payments = $query->get();

        if ($payments) {
            return $payments;
        }

        return null;
    }

    /**
     * @param array $data
     */
    public static function get($id): Model | null
    {
        $query = Payment::query();

        if (request('transaction')) {
            $query = $query->with('transaction');
        }

        $payment = $query->find($id);

        if ($payment) {
            return $payment;
        }
        return null;
    }

    /**
     * Create new transaction or fail
     * @param array $data
     * @return Model|bool
     */
    public static function store(array $data): Model | bool
    {
        DB::beginTransaction();
        try {
            $transaction = TransactionService::get($data['transaction_id']);
            if(empty($transaction) || $transaction->paid_amount >= $transaction->total_amount) {
                return false;
            }
            $payment = Payment::create($data);
            $transaction->update([
                'paid_amount' => $transaction->paid_amount + $payment->amount
            ]);
            DB::commit();
            return $payment->load('transaction');

        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * @param Model $model
     * @param array $data
     */
    public static function modify(Model $model, array $data)
    {
    }

    /**
     * @param Model $model
     */
    public static function destroy(Model $model)
    {
    }
}
