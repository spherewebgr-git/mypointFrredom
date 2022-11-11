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
                'value' =>  'ΔΙΑΚΡΙΤΙΚΟΣ ΤΙΤΛΟΣ',
            ],
            [
                'type' => 'company',
                'value' =>  'ΕΠΩΝΥΜΙΑ ΕΠΙΧΕΙΡΗΣΗΣ',
            ]
        ];
        DB::table('settings')->insert($settings);


    }
}
