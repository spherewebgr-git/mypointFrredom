<?php

namespace App\Http\Controllers;

use App\Models\Goods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoodsController extends Controller
{
    public function index()
    {
        $products = Goods::all();

        return view('products.index', ['products' => $products]);
    }
    public function create()
    {
        return view('products.create');
    }

    public function edit($product_number)
    {
        $product = Goods::query()->where('product_number', $product_number)->first();
        //dd($product);
        return view('products.create', ['product' => $product]);
    }

    public function store(Request $request)
    {
        //dd($request->file('image'));
        DB::table('goods')->insert([
            'product_number' => $request->product_number,
            'product_name' => $request->product_name,
            'product_description' => $request->product_description,
            'barcode' => $request->barcode,
            'price' => $request->price,
            'vat_price' => $request->vat_price,
            'discount_price' => $request->discount_price,
            'product_category' => $request->product_category,
            'product_vat_id' => $request->product_vat_id,
            'product_type' => 1,
            'mm_type' => $request->mm_type,
            'active' => 1
        ]);

        $newProduct = Goods::query()->where('product_number', '=', $request->product_number)->first();

        DB::table('goods_storages')->insert([
            'product_id' => $newProduct->id,
            'quantity' => $request->quantity,
        ]);
        if($request->image) {
            $name = str_replace([' ', '/', '\\'], '_', $request->file('image')->getClientOriginalName());
            $path = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, 'images' . DIRECTORY_SEPARATOR . 'products');
            $request->file('image')->storeAs($path, $name, ['disk' => 'public_folder']);
            $newProduct->update([
                'product_image' => $name,
            ]);
        }

        return redirect('/products');
    }

    public function update(Request $request)
    {
        $product = Goods::query()->where('id', '=', $request->product_id)->first();
        //dd($request);

        $product->update([
            'product_name' => $request->product_name,
            'product_description' => $request->product_description,
            'barcode' => $request->barcode,
            'product_category' => $request->product_category,
            'mm_type' => $request->mm_type,
            'product_vat_id' => $request->product_vat_id,
            'price' => $request->price,
            'vat_price' => $request->vat_price,
            'discount_price' => $request->discount_price,
            'active' => $request->active,
            'updated_at'  => date('Y-m-d H:i:s')
        ]);

        return back();
    }
}
