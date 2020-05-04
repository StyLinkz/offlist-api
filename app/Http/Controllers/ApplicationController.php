<?php

namespace App\Http\Controllers;

use App\User;
use App\Offer;
use App\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use JD\Cloudder\Facades\Cloudder;

class ApplicationController extends Controller
{
    public function index()
    {
        return Application::with(['user', 'offer'])
            ->orderByDesc('created_at')
            ->get();
    }

    public function show(Application $application)
    {
        return $application->load(['user', 'offer']);
    }

    public function store(Request $request)
    {
        $application = Application::create($request->all());
        return response()->json($application, 201);
    }

    public function delete(Application $application)
    {
        $application->delete();
        return response()->json(null, 204);
    }

    public function showAuthApplications() {
        $user = auth()->user();
        return Application::auth($user)
            ->with(['sender', 'user', 'offer'])
            ->orderByDesc('created_at')
            ->get();
    }

    public function showReceiveApplications() {
        $user = auth()->user();
        return Application::receive($user)
            ->with(['sender', 'user', 'offer'])
            ->orderByDesc('created_at')
            ->get();
    }

}
