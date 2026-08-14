<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::query()
            ->with(['category', 'orderedImages', 'activeVariants'])
            ->where('activo', true)
            ->where('destacado_home', true)
            ->where('promo', true)
            ->has('activeVariants')
            ->orderBy('nombre')
            ->limit(3)
            ->get();

        $settings = Setting::pluck('value', 'key');

        return view('home', compact('featuredProducts', 'settings'));
    }
}
