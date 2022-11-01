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
                'type' => 'invoices'
            ],
            [
                'letter' => 'ANEY',
                'type' => 'retails'
            ],
            [
                'letter' => 'ANEY',
                'type' => 'sale_invoices'
            ],
        ];
        Seires::insert($seires);
    }
}
