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
            $table->unsignedBigInteger('code_number')->unique();
            $table->string('name');
            $table->string('company');
            $table->string('work_title')->nullable();
            $table->string('address')->nullable();
            $table->string('number')->nullable();
            $table->string('city')->nullable();
            $table->unsignedBigInteger('postal_code')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('phone')->nullable();
            $table->string('vat')->nullable();
            $table->string('doy')->nullable();
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
