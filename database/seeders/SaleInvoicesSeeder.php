<?php

namespace Database\Seeders;

use App\Models\SaleInvoices;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SaleInvoicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('invoices')->delete();

        $jsonfile = File::get("database/data/sale_invoices.json");
        $data = json_decode($jsonfile, true);
        foreach ($data as $obj) {
            SaleInvoices::create([
                'hashID' =>  Str::substr(Str::slug(Hash::make($obj['seira'].$obj['sale_invoiceID'])), 0, 32),
                'seira' => $obj['seira'],
                'client_id' => $obj['client_id'],
                'sale_invoiceID' => $obj['sale_invoiceID'],
                'date'  => $obj['date'],
                'paid'  => $obj['paid'],
                'price' => $obj['price'],
                'vat' => $obj['vat'],
                'final' => $obj['final']
            ]);
        }
    }
}
