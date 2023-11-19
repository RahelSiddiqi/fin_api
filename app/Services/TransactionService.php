<?php

namespace App\Services;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class TransactionService implements ServiceInterface
{
    /**
     * @param array $data
     */
    public static function all(): Collection | null
    {
        $query = Transaction::query();
        if (request('payer')) {
            $query = $query->with('user');
        }
        if (request('payer_id')) {
            $query = $query->where('user_id', request('payer_id'))->with('user');
        }
        if (request('payments')) {
            $query = $query->with('payments');
        }
        $transactions = $query->get();
        if ($transactions) {
            return $transactions;
        }
        return null;
    }

    /**
     * @param array $data
     */
    public static function get($id): Model | null
    {
        $query = Transaction::query();

        if (request('payments')) {
            $query = $query->with('payments');
        }
        $transaction = $query->find($id);

        if ($transaction) {
            return $transaction;
        }
        return null;
    }

    /**
     * Create new user or fail
     * @param array $data
     * @return Model|bool
     */
    public static function store(array $data): Model | bool
    {
        try {
            $user = UserService::get($data['payer_id']);
            if($user->is_admin) {
                return false;
            }
            if ($data['is_vat_inc']) {
                $total = $data['amount'] + $data['amount'] * ($data['vat'] /100);
            } else {
                $total =$data['amount'];
            }

            $data = [
                'amount' => $data['amount'],
                'user_id' => $data['payer_id'],
                'due_on' => $data['due_on'],
                'vat' => $data['vat'],
                'is_vat_inc' => $data['is_vat_inc'],
                'total_amount' => $total,
                'paid_amount' => 0,
            ];

            $transaction = Transaction::create($data);

            return $transaction->load('user');
        } catch (\Throwable $th) {
            dd($th);
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
