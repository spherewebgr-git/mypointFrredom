<?php

namespace Database\Seeders;

use App\Models\Goods;
use App\Models\GoodsStorage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GoodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('goods')->delete();

        $jsonfile = File::get("database/data/products.json");
        $data = json_decode($jsonfile, true);
        foreach ($data as $obj) {
            Goods::create([
                'product_number' => $obj['productNumber'],
                'product_name' => $obj['productName'],
                'price'  => $obj['price'],
                'retail_price'  => $obj['retailPrice'],
                'vat_price'  => $obj['retailPrice'] - $obj['price'],
                'product_category'  => $obj['category'],
                'product_type'  => 1,
                'product_vat_id'  => $obj['vatId'],
                'mm_type'  => $obj['mm'],
            ]);

            GoodsStorage::create([
                'product_id' => $obj['productNumber'],
                'quantity' => 0,
                'held_quantity' => 0
            ]);

        }
    }
}
