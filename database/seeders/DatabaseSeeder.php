<?php

namespace Database\Seeders;


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
        $this->call(UsersSeeder::class);
        $this->call(SettingsSeeder::class);
//        $this->call(ClientsSeeder::class);
//        $this->call(InvoiceSeeder::class);
//        $this->call(ServicesSeeder::class);
//        $this->call(OutcomesSeeder::class);
//        $this->call(ReceiptsSeeder::class);
    }
}
