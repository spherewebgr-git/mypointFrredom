<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('hashID')->unique();
            $table->string('seira')->default('ΑΝΕΥ');
            $table->unsignedBigInteger('delivery_invoice_id');
            $table->unsignedBigInteger('client_id');
            $table->date('date');
            $table->time('time');
            $table->boolean('paid');
            $table->float('price');
            $table->float('vat');
            $table->float('final');
            $table->unsignedBigInteger('payment_method')->nullable()->default(5);
            $table->string('mark')->unique()->nullable();
            $table->string('file_invoice')->nullable();
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
        Schema::dropIfExists('delivery_invoices');
    }
}