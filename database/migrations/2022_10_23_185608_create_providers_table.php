<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id')->unique();
            $table->string('provider_name');
            $table->unsignedBigInteger('provider_vat')->unique();
            $table->string('provider_doy');
            $table->string('address');
            $table->string('address_number');
            $table->unsignedBigInteger('address_tk');
            $table->string('city');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('disabled')->default(false);
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
        Schema::dropIfExists('providers');
    }
}
