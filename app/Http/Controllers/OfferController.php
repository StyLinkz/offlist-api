<?php

namespace App\Http\Controllers;

use App\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function index()
    {
        return Offer::all();
    }

    public function show(Offer $offer)
    {
        return $offer;
    }

    public function store(Request $request)
    {
        $offer = Offer::create($request->all());
        return response()->json($offer, 201);
    }

    public function update(Request $request, Offer $offer)
    {
        $offer->update($request->all());
        return response()->json($offer, 200);
    }

    public function delete(Offer $offer)
    {
        $offer->delete();
        return response()->json(null, 204);
    }
}
