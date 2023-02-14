<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetailClassificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retail_classifications', function (Blueprint $table) {
            $table->id();
            $table->string('hashID');
            $table->string('outcome_hash');
            $table->string('classification_category');
            $table->string('classification_type');
            $table->date('date');
            $table->float('price', 8, 2);
            $table->string('vat');
            $table->string('mark');
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
        Schema::dropIfExists('retail_classifications');
    }
}
