<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('company')->nullable();
            $table->string('business')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('mobile')->nullable();
            $table->string('phone')->nullable();
            $table->string('vat')->nullable();
            $table->string('doy')->nullable();
            $table->string('logo')->nullable();
            $table->string('invoice_logo')->nullable();
            $table->string('signature')->nullable();
            $table->string('mail_account')->nullable();
            $table->string('aade_user_id')->nullable();
            $table->string('ocp_apim_subscription_key')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
