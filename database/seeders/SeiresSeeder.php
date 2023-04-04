<?php

namespace Database\Seeders;

use App\Models\Seires;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeiresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('seires')->delete();
        $seires = [
            [
                'letter' => 'ANEY',
                'type' => 'retails'
            ],
            [
                'letter' => 'ΑΛΠ',
                'type' => 'retails'
            ],
            [
                'letter' => 'ΑΛΠΣΑ',
                'type' => 'retails'
            ],
            [
                'letter' => 'ΤΙΜ',
                'type' => 'invoices'
            ],
            [
                'letter' => 'ΤΠΥ',
                'type' => 'invoices'
            ],
            [
                'letter' => 'ΑΠΥ',
                'type' => 'retails'
            ],
            [
                'letter' => 'ANEY',
                'type' => 'sale_invoices'
            ],
            [
                'letter' => 'ANEY',
                'type' => 'delivery_notes'
            ],
            [
                'letter' => 'ANEY',
                'type' => 'delivery_invoices'
            ]
        ];
        Seires::insert($seires);
    }
}
