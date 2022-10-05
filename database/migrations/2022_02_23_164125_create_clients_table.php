<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('hashID')->unique();
            $table->string('name');
            $table->string('company');
            $table->string('work_title');
            $table->string('email');
            $table->string('mobile')->nullable();
            $table->string('phone')->nullable();
            $table->string('address');
            $table->string('number');
            $table->string('city');
            $table->string('postal_code');
            $table->string('vat');
            $table->string('doy');
            $table->string('mail_account')->nullable();
            $table->string('phone_account')->nullable();
            $table->string('company_logo')->nullable();
            $table->boolean('disabled')->default(FALSE);
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
        Schema::dropIfExists('clients');
    }
}
