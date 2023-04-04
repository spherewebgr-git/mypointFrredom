<?php

namespace Database\Seeders;

use App\Models\ForeignProviders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ForeignProvidersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('invoices')->delete();

        $jsonfile = File::get("database/data/foreignProviders.json");
        $data = json_decode($jsonfile, true);
        foreach ($data as $obj) {
            ForeignProviders::create([
                'provider_id' => $obj['provider_id'],
                'provider_name' => $obj['provider_name'],
                'country_code' => $obj['country_code'],
                'provider_vat'  => $obj['vat'] ?? 0,
                'address'  => $obj['address'] ?? '',
                'address_number'  => $obj['address_number'] ?? '',
                'country'  => $obj['country'] ?? '',
                'city'  => $obj['city'] ?? '',
                'disabled'  => 0,
                'created_at' => date('Y-m-d')
            ]);
        }
    }
}
