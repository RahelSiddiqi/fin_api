<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->double(column: 'amount', places: 2, unsigned:true);
            $table->dateTime('due_on');
            $table->unsignedTinyInteger('vat');
            $table->boolean('is_vat_inc')->default(0);
            $table->double(column: 'total_amount', places: 2, unsigned:true);
            $table->double(column: 'paid_amount', places: 2, unsigned:true);
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
