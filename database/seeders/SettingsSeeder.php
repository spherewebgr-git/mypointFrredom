<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'title' => '',
            'company' => '',
            'business' => '',
            'email' => '',
            'address' => '',
            'mobile' => '',
            'phone' => '',
            'vat' => '',
            'doy' => '',
            'logo' => 'temp-logo.png',
            'invoice_logo' => 'temp-tim-logo.jpg',
            'signature' => 'tem-signature-logo',
            'mail_account' => '',
        ]);
    }
}
