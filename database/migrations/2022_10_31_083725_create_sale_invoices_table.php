<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('hashID')->unique();
            $table->string('seira')->default('ΑΝΕΥ');
            $table->unsignedBigInteger('sale_invoiceID');
            $table->unsignedBigInteger('client_id');
            $table->date('date');
            $table->boolean('paid');
            $table->unsignedBigInteger('payment_method')->nullable()->default(5);
            $table->string('mark')->unique()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_invoices');
    }
}
