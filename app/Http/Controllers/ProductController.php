<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Tag;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $guestToken = $request->cookie('guest_token') ?? session('guest_token');
        $query = Product::query()
            ->with([
                'images' => function ($q) {
                    $q->where('is_primary', true);
                },
                'sizes',
                'colors',
                'tags',
                'category'
            ])
            ->where('is_active', true)
            ->where('stock', '>', 0);

        // 🔍 Filters
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('offer')) {
            $query->whereHas('offers', function ($q) use ($request) {
                $q->where('slug', $request->offer);
            });
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('tags')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->whereIn('tags.id', (array) $request->tags);
            });
        }

        if ($request->filled('colors')) {
            $query->whereHas('colors', function ($q) use ($request) {
                $q->whereIn('colors.id', (array) $request->colors);
            });
        }

        // 🔃 Sorting
        if ($request->filled('sort')) {
            $sortField = match ($request->sort) {
                'price_asc' => ['price', 'asc'],
                'price_desc' => ['price', 'desc'],
                'newest' => ['created_at', 'desc'],
                default => ['created_at', 'desc']
            };
            $query->orderBy(...$sortField);
        }

        $products = $query->paginate($request->input('per_page', 12))->withQueryString();

        $guestToken = session('guest_token') ?? null;

        $products->getCollection()->transform(function ($product) use ($guestToken) {
            $product->in_wishlist = Wishlist::where('product_id', $product->id)
                ->when(Auth::check(), fn($q) => $q->where('user_id', Auth::id()))
                ->when(!Auth::check() && $guestToken, fn($q) => $q->where('guest_token', $guestToken))
                ->exists();
            return $product;
        });



        return Inertia::render('Products/Index', [
            'products' => $products,
            'categories' => Category::select('id', 'name', 'slug')->get(),
            'tags' => Tag::select('id', 'name')->where('is_active', true)->get(),
            'colors' => Color::select('id', 'name', 'class')->get(), // adjust if you have a color class column
            'filters' => $request->only([
                'search',
                'category',
                'gender',
                'tags',
                'colors',
                'min_price',
                'max_price',
                'sort'
            ])
        ]);
    }


    public function show($slug)
    {
        $product = Product::with([
            'images',
            'sizes',
            'colors',
            'tags',
            'category',
        ])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->firstOrFail();

        return Inertia::render('Products/Show', [
            'product' => $product
        ]);
    }
}
