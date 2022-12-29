<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveredGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivered_goods', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_hash');
            $table->string('delivery_type');
            $table->integer('delivered_good_id');
            $table->float('product_price');
            $table->integer('quantity');
            $table->float('line_vat');
            $table->float('line_final_price');
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
        Schema::dropIfExists('delivered_goods');
    }
}
