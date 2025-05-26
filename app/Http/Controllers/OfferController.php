<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Product;
use Inertia\Inertia;

class OfferController extends Controller
{
    public function show($slug)
    {
        $offer = Offer::where('slug', $slug)->firstOrFail();

        return inertia('Offers/Show', [
            'offer' => $offer,
        ]);
    }
}
