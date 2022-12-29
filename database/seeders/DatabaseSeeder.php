<?php

namespace Database\Seeders;


use App\Models\SaleInvoices;
use Database\Seeders\Auth\UsersSeeder;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        //$this->call(UsersSeeder::class);
        //$this->call(SettingsSeeder::class);
        //$this->call(SeiresSeeder::class);
        //$this->call(ClientsSeeder::class);
        //$this->call(SaleInvoicesSeeder::class);
        //$this->call(RetailsSeeder::class);
//        $this->call(OutcomesSeeder::class);
//        $this->call(ReceiptsSeeder::class);
        $this->call(DeliveryInvoicesSeeder::class);
    }
}
