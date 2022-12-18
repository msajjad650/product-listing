<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductType;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('products', [
            'products' => Product::title(request('title'))->productBrand(request('product_brand_id'))->productType(request('product_type_id'))->paginate(15),
            'productTypes' => ProductType::orderBy('name', 'asc')->get(),
            'productBrands' => ProductBrand::orderBy('name', 'asc')->get()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        // dd($product);
        return view('product-details', [
            'product' => $product
        ]);
    }
}
