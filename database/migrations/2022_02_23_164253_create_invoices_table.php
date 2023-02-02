<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('hashID')->unique();
            $table->string('seira')->default('ΑΝΕΥ');
            $table->unsignedBigInteger('invoiceID');
            $table->unsignedBigInteger('client_id');
            $table->date('date');
            $table->boolean('paid');
            $table->unsignedBigInteger('payment_method')->nullable()->default(5);
            $table->string('mark')->unique()->nullable();
            $table->string('cancelation_mark')->unique()->nullable();
            $table->string('file_invoice')->nullable();
            $table->integer('has_parakratisi');
            $table->integer('parakratisi_id')->default(3);
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
        Schema::dropIfExists('invoices');
    }
}
