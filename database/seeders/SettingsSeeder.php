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
        $settings= [
            [
                'type' => 'title',
                'value' =>  'Sanus Vita',
            ],
            [
                'type' => 'company',
                'value' =>  'ΑΛΕΞΑΚΗΣ ΘΕΟΔΩΡΟΣ - Sanus Vita',
            ],
            [
                'type' => 'business',
                'value' =>  'ΕΜΠΟΡΙΑ ΕΙΔΩN ΑΡΤΟΠΟΙΙΑΣ ΚΑΙ ΖΑΧΑΡΟΠΛΑΣΤΙΚΗΣ',
            ],
            [
                'type' => 'address',
                'value' =>  'ΠΛΑΤΩΝΟΣ 12, 17455, ΑΛΙΜΟΣ',
            ],
            [
                'type' => 'phone',
                'value' =>  '210-9825580',
            ],
            [
                'type' => 'vat',
                'value' =>  '079972831',
            ],
            [
                'type' => 'doy',
                'value' =>  'ΓΛΥΦΑΔΑΣ',
            ],
            [
                'type' => 'aade_user_id',
                'value' =>  'WW982808U952',
            ],
            [
                'type' => 'ocp_apim_subscription_key',
                'value' =>  '16e353606d8841a081574f93b77e22d5',
            ],
            [
                'type' => 'retails',
                'value' =>  'on',
            ],
            [
                'type' => 'delivery_invoices',
                'value' =>  'on',
            ],
            [
                'type' => 'invoices',
                'value' =>  'on',
            ],
            [
                'type' => 'delivery_notes',
                'value' =>  'on',
            ],
            [
                'type' => 'sale_invoices',
                'value' =>  'on',
            ]

        ];
        DB::table('settings')->insert($settings);


    }
}
