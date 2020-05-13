<?php

namespace App\Http\Controllers;

use App\Offer;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        return $user
            ->wishlistOffers()
            ->with(['user', 'type', 'category', 'tags', 'groups', 'wishlistUsers'])
            ->orderByDesc('created_at')
            ->get();
    }

    public function add($offerId)
    {
        $offer = Offer::find($offerId);

        if (!$offer) {
            throw new NotFoundHttpException;
        }

        $user = auth()->user();
        $user->wishlistOffers()->attach($offer);

        return response()->json($offer, 201);
    }

    public function remove($offerId)
    {
        $offer = Offer::find($offerId);

        if (!$offer) {
            throw new NotFoundHttpException;
        }

        $user = auth()->user();
        $user->wishlistOffers()->detach($offer);

        return response()->noContent();
    }
}
