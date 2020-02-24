<?php

namespace App\Http\Controllers;

use App\Invitation;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function index()
    {
        return Invitation::all();
    }

    public function show(Invitation $invitation)
    {
        return $invitation;
    }

    public function store(Request $request)
    {
        $invitation = Invitation::create($request->all());
        return response()->json($invitation, 201);
    }

    public function update(Request $request, Invitation $invitation)
    {
        $invitation->update($request->all());
        return response()->json($invitation, 200);
    }

    public function delete(Invitation $invitation)
    {
        $invitation->delete();
        return response()->json(null, 204);
    }
}
