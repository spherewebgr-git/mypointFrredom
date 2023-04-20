<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleInvoicesItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_invoices_items', function (Blueprint $table) {
            $table->id();
            $table->string('invoiceHash');
            $table->integer('payment_method')->default(3);
            $table->string('product_id');
            $table->integer('quantity')->default(1);
            $table->float('price');
            $table->float('vat');
            $table->unsignedBigInteger('vat_id')->default(1);
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
        Schema::dropIfExists('sale_invoices_items');
    }
}
