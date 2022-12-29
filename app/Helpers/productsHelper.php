<?php

use App\Models\Goods;

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
