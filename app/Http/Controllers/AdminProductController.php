<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Size;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::select(['id', 'name', 'slug', 'price', 'stock', 'category_id'])
            ->with(['category:id,name', 'sizes:id,name', 'images:id,path,is_primary,product_id'])
            ->get()
            ->map(function ($product) {
                // Modify the image path to include the storage URL
                $product->images->each(function ($image) {
                    $image->path = asset('storage/' . $image->path); // Generate the full URL
                });
                return $product;
            });

        return Inertia::render('admin/products/Product_list', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all(['id', 'name']);
        $tags = Tag::all(['id', 'name']);
        $sizes = Size::all(['id', 'name']);
        $colors = Color::all(['id', 'name', 'class']);
        return Inertia::render('admin/products/Create', ['categories' => $categories, 'tags' => $tags, 'sizes' => $sizes, 'colors' => $colors]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        // return $request;
        DB::transaction(function () use ($request) {
            $product = Product::create([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'brand' => $request->brand,
                'weight' => $request->weight,
                'gender' => $request->gender,
                'description' => $request->description,
                'tag_number' => $request->tag_number,
                'stock' => $request->stock,
                'price' => $request->price,
                'is_active' => $request->is_active ?? true,
            ]);

            // Attach sizes, colors, and tags
            $product->sizes()->sync($request->sizes);
            $product->colors()->sync($request->colors);
            $product->tags()->sync($request->tags);

            // Handle images
            $imageData = collect($request->images)->map(function ($image) use ($product) {
                if (!isset($image['file'])) {
                    return null;
                }

                return [
                    'product_id' => $product->id,
                    'path'       => $image['file']->store('products', 'public'),
                    'is_primary' => filter_var($image['is_primary'], FILTER_VALIDATE_BOOLEAN), // Convert to boolean
                    'created_at' => now(),
                ];
            })->filter()->toArray();

            ProductImage::insert($imageData);
        });

        return redirect()->route('products.list')->with('success', 'Product created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->with(['sizes', 'colors', 'tags', 'images', 'category'])
            ->firstOrFail();

        $images = $product->images->map(function ($image) {
            return [
                'id' => $image->id,
                'is_primary' => $image->is_primary,
                'path' => asset('storage/' . $image->path), // Generate full URL for the image
            ];
        });

        $productArray = $product->toArray();  // Convert product to array
        $productArray['images'] = $images;  // Add images array to product data

        $category = Category::all(['id', 'name']);
        $tags = Tag::all(['id', 'name']);
        $sizes = Size::all(['id', 'name']);
        $colors = Color::all(['id', 'name', 'class']);

        return Inertia::render('admin/products/Show', [
            'product' => $productArray,
            'category' => $category,
            'tags' => $tags,
            'sizes' => $sizes,
            'colors' => $colors
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product->load(['sizes', 'colors', 'tags', 'images']); // Load relationships after retrieving the model

        $images = $product->images->map(function ($image) {
            return [
                'id' => $image->id,
                'is_primary' => $image->is_primary,
                'path' => asset('storage/' . $image->path), // Generate full URL for the image
            ];
        });

        $productArray = $product->toArray();  // Convert product to array
        $productArray['images'] = $images;  // Add images array to product data

        $categories = Category::all(['id', 'name']);
        $tags = Tag::all(['id', 'name']);
        $sizes = Size::all(['id', 'name']);
        $colors = Color::all(['id', 'name', 'class']);
        return Inertia::render('admin/products/Edit', [
            'product' => $productArray,
            'categories' => $categories,
            'tags' => $tags,
            'sizes' => $sizes,
            'colors' => $colors
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {

        $request = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand' => 'required|string|max:255',
            'weight' => 'nullable|numeric',
            'gender' => 'required|in:male,female',

            'sizes' => 'required|array',
            'sizes.*' => 'integer|exists:sizes,id',

            'colors' => 'required|array',
            'colors.*' => 'integer|exists:colors,id',

            'description' => 'required|string',
            'tag_number' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:0',

            'tags' => 'required|array',
            'tags.*' => 'required|exists:tags,id',

            'price' => 'required|numeric|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $product->update($request);

        // Sync relationships
        $product->sizes()->sync($request['sizes']);
        $product->colors()->sync($request['colors']);
        $product->tags()->sync($request['tags']);

        return redirect()->route('products.list')->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete(); // Soft delete

        return redirect()->route('products.list')->with('success', 'Product deleted successfully');
    }
}
