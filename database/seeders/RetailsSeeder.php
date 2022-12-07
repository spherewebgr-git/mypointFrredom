<?php

namespace Database\Seeders;


use App\Models\Retails;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('retails')->delete();

        $jsonfile = File::get("database/data/retails.json");
        $data = json_decode($jsonfile, true);
        foreach ($data as $obj) {
            Retails::create([
                'hashID' =>  Str::substr(Str::slug(Hash::make($obj['seira'].$obj['retailID'])), 0, 32),
                'date' => $obj['date'],
                'seira' => $obj['seira'],
                'retailID' => $obj['retailID']
            ]);
        }
    }
}
