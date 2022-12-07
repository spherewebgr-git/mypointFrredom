<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetailReceiptsItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retail_receipts_items', function (Blueprint $table) {
            $table->id();
            $table->string('retailHash');
            $table->integer('payment_method')->default(3);
            $table->string('product_service');
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
        Schema::dropIfExists('retail_receipts_items');
    }
}
