<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retails', function (Blueprint $table) {
            $table->id();
            $table->string('hashID')->unique();
            $table->unsignedBigInteger('retailID')->unique();
            $table->date('date');
            $table->string('seira')->nullable()->default('ΑΝΕΥ');
            $table->float('price');
            $table->unsignedBigInteger('payment_method')->nullable()->default(3);
            $table->float('vat');
            $table->string('service')->nullable();
            $table->string('description')->nullable();
            $table->string('mark')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('retails');
    }
}
