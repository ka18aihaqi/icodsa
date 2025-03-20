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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('loa_id')->constrained('letter_of_acceptances')->onDelete('cascade');
            $table->string('description')->nullable();
            $table->integer('quantity')->default(1);
            $table->enum('currency', ['IDR', 'USD', 'EUR'])->default('IDR');
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('total', 10, 2)->nullable();
            
            $table->foreignId('virtual_account_id')->nullable()->constrained('virtual_accounts')->onDelete('set null');
            $table->foreignId('bank_transfer_id')->nullable()->constrained('bank_transfers')->onDelete('set null');
            
            $table->enum('status', ['Paid', 'Unpaid'])->default('Unpaid');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
