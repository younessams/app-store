<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class AdminOfferController extends Controller
{

    public function index(Request $request)
    {
        $offers = Offer::query();

        if ($request->filled('status')) {
            $offers->where('is_active', $request->status === 'active');
        }

        if ($request->filled('discout')) {
            $offers->where('discount_type', $request->discout);
        }

        if ($request->filled('start_date')) {
            $offers->whereDate('start_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $offers->whereDate('end_date', '<=', $request->end_date);
        }

        return inertia('admin/offers/Index', [
            'offers' => $offers->latest()->paginate(10)->withQueryString(),
            'filters' => $request->only(['status', 'discout', 'start_date', 'end_date']),
        ]);
    }


    public function create()
    {
        $products = Product::where('is_active', true)
            ->select(['id', 'name'])
            ->get();
        return Inertia::render('admin/offers/Create', ['products' => $products]);
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'boolean',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // Allow 5MB max
            'products' => [
                'required',
                'array',
                function ($attribute, $value, $fail) {
                    // Ensure the value is a flat array of product IDs
                    $productIds = is_array($value) ? $value : [];

                    // Ensure all selected products are active
                    $inactiveProducts = Product::whereIn('id', $productIds)->where('is_active', false)->get();
                    if ($inactiveProducts->isNotEmpty()) {
                        $fail('All selected products must have is_active set to true.');
                    }
                }
            ],
        ]);

        // Create the offer data array
        $offerData = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'discount_type' => $validated['discount_type'],
            'discount_value' => $validated['discount_value'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'is_active' => $validated['is_active'] ?? true, // default to true if not provided
        ];

        // Handle image upload if present
        if ($request->hasFile('image_url') && $request->file('image_url')->isValid()) {
            $image = $request->file('image_url');
            $imageName = time() . '_' . $image->getClientOriginalName();

            // Store the image in the offers directory within the public storage
            $imagePath = $image->storeAs('offers', $imageName, 'public');

            // Add the image path to the offer data
            $offerData['image_url'] = 'storage/' . $imagePath;
        }

        // Create the offer
        $offer = Offer::create($offerData);

        // Attach the selected products to the offer
        $offer->products()->attach($validated['products']);

        // Redirect to the offers index page with a success message
        return redirect()->route('offers.index')->with('success', 'Offer created successfully.');
    }


    public function edit(Offer $offer)
    {
        // $offer->load('products'); // Eager load products relationship
        $productIds = $offer->products->pluck('id')->toArray();

        // Fetch active products
        $products = Product::where('is_active', true)
            ->select(['id', 'name'])
            ->get();

        // Pass the offer and products to the Inertia component
        return inertia('admin/offers/Edit', [
            'offer' => $offer, // Offer data with products
            'products' => $products, // List of active products
            'offerProducts' => $productIds,
        ]);
    }


    public function update(Request $request, Offer $offer)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'required|boolean',
            'products' => 'required|array',
            'products.*' => 'exists:products,id',
            'image' => 'nullable|image|max:2048', // 2MB max size
        ]);

        // Handle image upload if a new image was provided
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if (
                $offer->image_url && !filter_var($offer->image_url, FILTER_VALIDATE_URL) &&
                !str_starts_with($offer->image_url, 'http')
            ) {
                Storage::disk('public')->delete($offer->image_url);
            }

            // Store the new image
            $path = $request->file('image')->store('offers', 'public');
            $offer->image_url = $path;
        }

        // Update other offer fields
        $offer->title = $validated['title'];
        $offer->description = $validated['description'] ?? null;
        $offer->discount_type = $validated['discount_type'];
        $offer->discount_value = $validated['discount_value'];
        $offer->start_date = $validated['start_date'];
        $offer->end_date = $validated['end_date'];
        $offer->is_active = $validated['is_active'];

        $offer->save();

        // Sync products
        $offer->products()->sync($validated['products']);

        return redirect()->route('offers.index')
            ->with('success', 'Offer updated successfully.');
    }

    public function destroy(Offer $offer)
    {
        $offer->delete();
        return back()->with('success', 'Offer deleted successfully.');
    }
}
