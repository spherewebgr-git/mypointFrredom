<?php

namespace Database\Seeders;

use App\Models\DeliveredGoods;
use App\Models\DeliveryInvoices;
use App\Models\Invoice;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DeliveryInvoicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::table('delivery_invoices')->delete();

        $jsonfile = File::get("database/data/delivery_invoices.json");
        $data = json_decode($jsonfile, true);

        foreach ($data as $obj) {
            $hash = Str::substr(Str::slug(Hash::make($obj['seira'].$obj['delivery_invoice_id'])), 0, 32);
            DeliveryInvoices::create([
                'hashID' =>  $hash,
                'seira' => $obj['seira'],
                'delivery_invoice_id' => $obj['delivery_invoice_id'],
                'client_id' => $obj['client'],
                'sendFrom' => $obj['sendFrom'],
                'sendTo' => $obj['sendTo'],
                'date'  => $obj['date'],
                'time' => '00:00:00',
                'paid'  => $obj['paid'],
                'payment_method' => $obj['payment_method']
            ]);

            DeliveredGoods::create([
                'invoice_hash' => $hash,
                'delivery_type' => 'delivery_invoice',
                'delivered_good_id' => 1,
                'product_price' => $obj['product_price'],
                'quantity' => 1,
                'line_vat' => $obj['line_vat'],
                'line_final_price' => $obj['line_final_price'],
            ]);
        }
    }
}
