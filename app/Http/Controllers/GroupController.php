<?php

namespace App\Http\Controllers;

use App\Group;
use App\Contact;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return Group::auth($user)
            ->with(['contacts'])
            ->orderByDesc('created_at')
            ->get();
    }

    public function show(Group $group)
    {
        return $group->load('contacts');
    }

    public function store(Request $request)
    {
        $group = Group::create($request->all());

        /* Save tags */
        if ($request->input('contacts')) {
            $contacts = Contact::find($request->input('contacts'));
            $group->contacts()->attach($contacts);
        }

        return response()->json($group, 201);
    }

    public function update(Request $request, Group $group)
    {
        $group->update($request->all());

        /* Detach current contacts */
        $currentContactIds = [];
        foreach ($group->contacts as $contact) {
            $currentContactIds[] = $contact->id;
        }
        if (!empty($currentContactIds)) {
            $group->contacts()->detach($currentContactIds);
        }

        /* Save new contacts */
        if ($request->input('contacts')) {
            $contacts = Contact::find($request->input('contacts'));
            $group->contacts()->attach($contacts);
        }

        return response()->json($group, 200);
    }

    public function delete(Group $group)
    {
        $group->delete();
        return response()->json(null, 204);
    }

}
