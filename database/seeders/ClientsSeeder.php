<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\ClientAddresses;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clients')->delete();
        $jsonfile = File::get("database/data/clients.json");
        $data = json_decode($jsonfile, true);
        foreach ($data as $obj) {
            $hash = Str::substr(Str::slug(Hash::make($obj['company'].$obj['vat'])), 0, 32);
            Client::create([
                'hashID' =>  $hash,
                'code_number' => $obj['code_number'],
                'name' => $obj['name'],
                'company' => $obj['company'],
                'work_title'  => $obj['work_title'],
                'email'  => $obj['email'],
                'mobile'  => $obj['mobile'],
                'phone'  => $obj['phone'],
                'vat'  => $obj['vat'],
                'doy'  => $obj['doy'],
                'mail_account'  =>'',
                'phone_account'  => '',
            ]);
            if($obj['address'] != null) {
                ClientAddresses::create([
                    'client_hash' => $hash,
                    'address_type' => 0,
                    'address_name' => 'Έδρα',
                    'address' => $obj['address'],
                    'number' => $obj['number'],
                    'city' => $obj['city'],
                    'postal_code' => $obj['postal_code']
                ]);
            }

        }
    }
}
