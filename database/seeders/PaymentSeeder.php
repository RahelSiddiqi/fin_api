<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transactions = Transaction::all();
        foreach ($transactions as $transaction) {
            $amount = fake()->randomElement([100, 200, 300, 400, 500]);
            $transaction->update([
                'paid_amount' => $transaction->paid_amount + $amount,
            ]);
            $transaction->payments()->create([
                "amount"  => $amount,
                "paid_on" => Carbon::now()->subDays(rand(1, 1000)),
                "comment" => fake()->sentence(),
            ]);
            if ($transaction->paid_amount < $transaction->total_amount) {
                if (rand(0, 1)) {
                    $amount = $transaction->total_amount - $transaction->paid_amount;
                } else {
                    $amount = rand(1, $transaction->total_amount - $transaction->paid_amount);
                }
                $transaction->payments()->create([
                    "amount"  => $amount,
                    "paid_on" => Carbon::now()->subDays(rand(1, 1000)),
                    "comment" => fake()->sentence(),
                ]);
            }
        }
    }
}
