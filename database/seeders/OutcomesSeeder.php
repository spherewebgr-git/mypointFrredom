<?php

namespace Database\Seeders;

use App\Models\Outcomes;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OutcomesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('outcomes')->delete();

        $jsonfile = File::get("database/data/outcomes.json");
        $data = json_decode($jsonfile, true);
        foreach ($data as $obj) {
            Outcomes::create([
                'hashID' =>  Str::substr(Str::slug(Hash::make($obj['shop'].$obj['invoice_number'])), 0, 32),
                'outcome_number' => $obj['invoice_number'],
                'shop' => $obj['shop'],
                'date' => $obj['date'],
                'price' => $obj['price'],
                'vat' => $obj['vat'],
                'file' => $obj['file'],
            ]);
        }
    }
}
