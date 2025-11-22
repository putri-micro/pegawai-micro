<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('file_path'); // Path ke file invoice
            $table->string('invoice_number')->nullable(); // Nomor invoice
            $table->decimal('amount', 10, 2)->nullable(); // Jumlah
            $table->foreignId('user_id')->nullable()->constrained(); // Pemilik invoice
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};