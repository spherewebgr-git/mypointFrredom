<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('hashID');
            $table->string('client_hash');
            $table->string('service_title');
            $table->string('service_type');
            $table->string('service_domain')->nullable();
            $table->date('first_payment');
            $table->string('service_duration');
            $table->boolean('active_subscription')->default(1);
            $table->date('last_payed')->nullable();
            $table->float('duration_price', 8, 2);
            $table->boolean('client_notified')->default(0);
            $table->date('client_notified_at')->nullable();
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
        Schema::dropIfExists('subscriptions');
    }
}
