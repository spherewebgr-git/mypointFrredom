<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutcomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outcomes', function (Blueprint $table) {
            $table->id();
            $table->string('hashID')->unique();
            $table->string('seira')->nullable();
            $table->bigInteger('outcome_number')->nullable();
            $table->string('shop')->nullable();
            $table->date('date');
            $table->float('price');
            $table->float('vat');
            $table->string('invType')->nullable();
            $table->string('mark')->nullable();
            $table->string('file')->nullable();
            $table->string('status')->nullable();
            $table->integer('classified')->default(0);
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
        Schema::dropIfExists('outcomes');
    }
}
