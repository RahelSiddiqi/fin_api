<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create([
            'is_admin'          => false,
            'email_verified_at' => now(),
        ]);

        \App\Models\User::factory()->create([
            'name'              => 'admin',
            'email'             => 'admin@mail.com',
            'is_admin'          => true,
            'email_verified_at' => now(),
        ]);
        $this->call([
            TransactionSeeder::class,
            PaymentSeeder::class,
        ]);
    }
}
