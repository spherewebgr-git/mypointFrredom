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
            $table->string('invoiceType')->nullable();
            $table->string('seira')->default('ΑΝΕΥ');
            $table->unsignedBigInteger('retailID');
            $table->date('date');
            $table->string('client_description')->nullable();
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
