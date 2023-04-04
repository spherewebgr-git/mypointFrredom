<?php

namespace Database\Seeders;

use App\Models\Provider;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProvidersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('invoices')->delete();

        $jsonfile = File::get("database/data/providers.json");
        $data = json_decode($jsonfile, true);
        foreach ($data as $obj) {
            Provider::create([
                'provider_id' => $obj['providerId'],
                'provider_name' => $obj['name'],
                'provider_vat'  => $obj['providerVat'] ?? 0,
                'address'  => $obj['address'] ?? '',
                'address_number'  => $obj['number'] ?? '',
                'city'  => $obj['city'] ?? '',
                'disabled'  => 0,
                'created_at' => date('Y-m-d')
            ]);
        }
    }
}
