<?php

namespace Database\Seeders;

use App\Models\Client;
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
            Client::create([
                'id' => $obj['id'],
                'hashID' =>  Str::substr(Str::slug(Hash::make($obj['company'].$obj['vat'])), 0, 32),
                'name' => $obj['name'],
                'company' => $obj['company'],
                'work_title'  => $obj['work_title'],
                'email'  => $obj['email'],
                'mobile'  => $obj['mobile'],
                'phone'  => $obj['phone'],
                'address'  => $obj['address'],
                'city'  => $obj['city'],
                'vat'  => $obj['vat'],
                'doy'  => $obj['doy'],
                'mail_account'  => $obj['mail_account'],
                'phone_account'  => $obj['phone_account'],
            ]);
        }
    }
}
