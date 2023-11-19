<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('is_admin', 0)->get();
        foreach ($users as $user) {
            for ($i = 0; $i < rand(1, 3); $i++) {
                $amount = fake()->randomElement([500, 1500, 1000, 2000]);
                $vat    = rand(10, 25);
                $is_vat = rand(0, 1);
                $user->transactions()->create([
                    "amount"       => $amount,
                    "due_on"       => Carbon::now()->subDays(rand(1, 1000)),
                    "vat"          => $vat,
                    "is_vat_inc"   => $is_vat,
                    'total_amount' => $is_vat ? $amount + ($amount * ($vat / 100)) : $amount,
                    "paid_amount"  => 0,
                ]);
            }
        }
    }
}
