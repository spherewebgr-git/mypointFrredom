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
                'value' =>  'TRE SPORT',
            ],
            [
                'type' => 'company',
                'value' =>  'ΤΡΙΑ ΣΠΟΡ - ΑΘΛΗΤΙΚΑ ΕΙΔΗ Ε.Π.Ε.',
            ],
            [
                'type' => 'business',
                'value' =>  'ΑΘΛΗΤΙΚΑ ΕΙΔΗ',
            ],
            [
                'type' => 'address',
                'value' =>  'ΣΑΡΚΟΥΔΙΝΟΥ 67, 11744, ΑΘΗΝΑ',
            ],
            [
                'type' => 'phone',
                'value' =>  '210-9020120',
            ],
            [
                'type' => 'vat',
                'value' =>  '099455517',
            ],
            [
                'type' => 'doy',
                'value' =>  'ΙΖ ΑΘΗΝΩΝ',
            ],
            [
                'type' => 'aade_user_id',
                'value' =>  'triasporepe',
            ],
            [
                'type' => 'ocp_apim_subscription_key',
                'value' =>  '7b10c5fb49b6442a931d3322b354246c',
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
                'value' =>  'off',
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
