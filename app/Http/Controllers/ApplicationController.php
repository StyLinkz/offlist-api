<?php

namespace App\Http\Controllers;

use Mail;
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
        return Application::with(['user', 'offer', 'sender'])
            ->orderByDesc('created_at')
            ->get();
    }

    public function show(Application $application)
    {
        return $application->load(['user', 'offer', 'sender']);
    }

    public function store(Request $request)
    {
        $application = Application::create($request->all());
        return response()->json($application, 201);
    }

    public function update(Request $request, Application $application)
    {
        $application->update($request->all());
        return response()->json($application, 200);
    }

    public function delete(Application $application)
    {
        $application->delete();
        return response()->json(null, 204);
    }

    public function deleteOfferRequests(Request $request)
    {
      if ($request->input('offerId')) {
        $applications = Application::where('offer_id', $request->input('offerId'))->get();
        foreach ($applications as $application) {
          // TODO: Notify the sender about the delete action
          $this->_sendDeleteNotification($application);

          // Update application status
          $application->update([
            'status' => 'deleted',
          ]);
        }
        return response()->json($applications, 200);
      }
      return response()->json([], 200);
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

    protected function _sendDeleteNotification(Application $application)
    {
        $to_name = $application->sender_prename . ' ' . $application->sender_name;
        $to_email = $application->sender_email;
        $data = [
            'application' => [
                'sender_prename' => $application->sender_prename,
                'sender_name' => $application->sender_name,
                'sender_email' => $application->sender_email,
            ],
        ];
        Mail::send(
            'templates.mail.deleteOfferNotification',
            $data,
            function ($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)
                    ->subject('[Offlist] Offer Delete Notification');
                $message->from('info@offlist.de', 'Offlist');
            }
        );
    }
}
