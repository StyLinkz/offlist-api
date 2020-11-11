<?php

namespace App\Http\Controllers;

use App\User;
use Mail;
use App\AccessRequest;
use Illuminate\Http\Request;

class AccessRequestController extends Controller
{
    public function index()
    {
        return AccessRequest::all();
    }

    public function show(AccessRequest $accessRequest)
    {
        return $accessRequest;
    }

    public function store(Request $request)
    {
        $request_data = $request->all();
        $access_request = AccessRequest::create($request_data);
        return response()->json($access_request, 201);
    }

    public function update(Request $request, AccessRequest $accessRequest)
    {
        $accessRequest->update($request->all());
        return response()->json($accessRequest, 200);
    }

    public function delete(AccessRequest $accessRequest)
    {
        $accessRequest->delete();
        return response()->json(null, 204);
    }

    protected function _sendNotificationToAdmin($accessRequest) {
        /* @TODO: Send notification email to the admin */
        // $to_name = $invitation['receiver_prename'] . ' ' . $invitation['receiver_name'];
        // $to_email = $invitation['receiver_email'];
        // $data = [
        //     'invitation' => $invitation,
        // ];
        // Mail::send(
        //     'templates.mail.invitation',
        //     $data,
        //     function($message) use ($to_name, $to_email) {
        //         $message->to($to_email, $to_name)
        //                 ->subject('Invitation to join Offlist');
        //         $message->from('info@offlist.de', 'Offlist');
        //     }
        // );
    }

}
