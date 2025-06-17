<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function prices(Request $request)
    {
        $currency = strtoupper($request->query('currency', 'RUB'));
        $products = Product::all();

        return ProductResource::collection($products->map(function ($product) use ($currency) {
            $product->converted_currency = $currency;
            return $product;
        }));
    }
}
