<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Products;

class ProductsController extends Controller
{
    public function all()
    {
        $productsCategorized = [];

        $products = Products::all();

        $products = $products->map(function ($product) use (&$productsCategorized) {
            $product->description = json_decode($product->description);
            $product->category = json_decode($product->category);

            $category = $product->category[0];

            $productsCategorized[$category][] = $product;

            return $product;
        });

        return response()->json($productsCategorized);
    }
}
