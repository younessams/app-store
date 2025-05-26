<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Offer;
use App\Models\Product;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with(['images'])
            ->where('is_active', true)
            ->limit(6)
            ->get();

        $categories = Category::all();
        $offers = Offer::latest()->get();

        return Inertia::render('Home', [
            'offers'=> $offers,
            'products' => $products,
            'categories' => $categories,
        ]);
    }
}
