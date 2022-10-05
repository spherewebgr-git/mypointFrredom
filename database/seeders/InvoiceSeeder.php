<?php

namespace Database\Seeders;

use App\Models\Invoice;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('invoices')->delete();

        $jsonfile = File::get("database/data/invoices.json");
        $data = json_decode($jsonfile, true);
        foreach ($data as $obj) {
            Invoice::create([
                'hashID' =>  Str::substr(Str::slug(Hash::make($obj['client_id'].$obj['invoice_number'])), 0, 32),
                'client_id' => $obj['client_id'],
                'invoiceID' => $obj['invoice_number'],
                'date'  => $obj['date'],
                'paid'  => $obj['paid'],
            ]);
        }
    }
}
