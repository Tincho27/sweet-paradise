<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::query()
            ->with(['category', 'images', 'activeVariants'])
            ->where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('products', compact('products'));
    }
}
