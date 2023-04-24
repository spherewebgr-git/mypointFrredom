<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->id();
            $table->string('product_number')->unique();
            $table->integer('woocommerce_id')->unique();
            $table->text('product_name');
            $table->text('product_description')->nullable();
            $table->text('barcode')->nullable();
            $table->text('product_image')->nullable();
            $table->float('price');
            $table->float('retail_price')->nullable();
            $table->float('vat_price')->nullable();
            $table->float('discount_price')->nullable();
            $table->text('product_category')->nullable();
            $table->integer('product_vat_id')->default(1);
            $table->integer('product_type')->default(1);
            $table->integer('mm_type')->default(101);
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('goods');
    }
}
