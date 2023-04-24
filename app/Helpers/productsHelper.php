<?php

use App\Models\Goods;
use Codexshaper\WooCommerce\Facades\Product;

if(!function_exists('getProductVat')) {
    function getProductVat($productId) {
        $product = Goods::query()->where('id', '=', $productId)->first();

        $productVat = $product->vat_price;

        return $productVat;
    }
}

if(!function_exists('getMmType')) {
    function getMmType($productId) {
        $product = Goods::query()->where('id', '=', $productId)->first();

        $productMm = $product->mm_type;

        switch ($productMm)
        {
            case '101':
                return 'Τεμάχια';
            case '107' :
                return 'Κιβώτια';
            case '120' :
                return 'Μέτρα';
            case '141' :
                return 'Λίτρα';
            case '150' :
                return 'Κιλά';
        }

        return '';
    }
}

if(!function_exists('getProduct')) {
    function getProduct($productId) {
        $productById = Goods::query()->where('id', '=', $productId)->first();

        return $productById;
    }
}

if(!function_exists('eshopUpdateProductStorage')) {
    function eshopUpdateProductStorage($productHash) {
        $product = Goods::query()->where('hashID', '=', $productHash)->first();

        $data = [
            'stock_quantity' => $product->storage->quantity ?? 0,
            'stock_status' => ($product->storage->quantity != 0 || $product->active == 1) ? 'instock' : 'outofstock'
        ];

        Product::update($product->woocommerce_id, $data);
    }
}
