<?php

namespace App\Http\Controllers;

use App\Models\Goods;
use Illuminate\Http\Request;
use Codexshaper\WooCommerce\Facades\Product;
use Illuminate\Support\Facades\Storage;

class ShopConnectController extends Controller
{
    public function getProductImage(Request $request) {

        $product_id = $request->product_id;
        $product = Product::find($product_id);
        $good = Goods::query()->where('woocommerce_id', '=', $product_id)->first();

        $decode = json_decode($product);
        $img = $decode->images[0]->src;
        $contents = file_get_contents($img);
        $name = substr($img, strrpos($img, '/') + 1);
        Storage::disk('public_folder')->put('images/products/'.$name, $contents);
        $good->update([
            'product_image' => $name
        ]);

        return $decode->images[0]->src;
    }

    public function updateEshopStorage(){
        $products = Goods::all();
        $toUpdate = [];
        foreach($products as $product) {
            $toUpdate[] = [
                'id' => $product->woocommerce_id,
                'stock_quantity' => $product->storage->quantity ?? 0,
                'stock_status' => ($product->storage->quantity != 0 || $product->active == 1) ? 'instock' : 'outofstock'
            ];
        }
        $data = [
            'update' => $toUpdate
        ];
        Product::batch($data);
    }
}
