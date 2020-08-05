<?php

namespace App\Http\Controllers;

use App\User;
use Mail;
use App\Contact;
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
        $user = auth()->user();

        if ($receiver_email = $request->input('receiver_email')) {
            /* Return error if the email was used for another contact */
            $found_invitation_number = Invitation::auth($user)->where('receiver_email', $receiver_email)->count();
            if ($found_invitation_number > 0) {
                return response()->json(['error' => 'The email was used for another contact.'], 422);
            }

            /* Return error if the email was used for an available user */
            $found_user_number = User::whereEmail($receiver_email)->count();
            if ($found_user_number > 0) {
                return response()->json(['error' => 'This email was used by another user.'], 422);
            }
        }


        /* Generate invitation code */
        $code = $this->_generateInvitationCode();

        /* Send the invitation code */
        $this->_sendInvitationCode(array_merge(
            $request->all(),
            [
                'code' => $code,
                'sender_name' => $user->prename . ' ' . $user->name,
            ]
        ));

        /* Save the invitation */
        $invitation = Invitation::create(
            array_merge(
                $request->all(),
                [
                    'user_id' => $user->id,
                    'code' => $code,
                    'expired_at' => date('Y-m-d H:i:s', strtotime(' + 14 days'))
                ]
            )
        );

        /* Reduce the invitation limit */
        $user->update([
            'invitation_limit' => $user->invitation_limit - 1,
        ]);

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

    public function showAuthInvitations() {
        $user = auth()->user();
        return Invitation::auth($user)
            ->with(['user'])
            ->orderByDesc('created_at')
            ->get();
    }

    public function getInvitationLimit() {
        $user = auth()->user();
        return $user->invitation_limit;
    }

    public function checkInvitation(Request $request) {
        if ($code = $request->input('code')) {
            $results = Invitation::where('code', '=', $code)
                ->where('status', '=', 'pending');
            if (!$results->count()) {
                return response()->json(['error' => 'Invitation is not found'], 404);
            }
            $invitation = $results->get()[0];

            /* Check if the invitation is expired or not */
            if ($invitation->expired_at < date('Y-m-d 00:00:00')) {
                $invitation->update([
                    'status' => 'expired',
                ]);
                return response()->json(['error' => 'The invitation is expired'], 406);
            }

            return response()->json($invitation, 200);
        }
        return response()->json(['error' => 'Some data is not correct.'], 422);
    }

    public function updateInvitationStatus(Request $request, Invitation $invitation) {
        /* Set the registered user as a new contact of the invitation sender */
        $status = $request->input('status');
        if ($status == 'accepted') {
            Contact::create([
                'user_id' => $invitation->user_id,
                'contact_user_id' => $request->input('contact_user_id'),
                'name' => $request->input('contact_name'),
                'prename' => $request->input('contact_prename'),
                'email' => $request->input('contact_email'),
            ]);

            /* Set the receiver_id of the invitation */
            $invitation->update([
                'receiver_id' => $request->input('contact_user_id'),
            ]);
        }

        /* Update the status of the invitation */
        $invitation->update([
            'status' => $status,
        ]);

        return response()->json($invitation, 200);
    }

    protected function _generateInvitationCode($length = 6) {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }

    protected function _sendInvitationCode($invitation) {
        $to_name = $invitation['receiver_prename'] . ' ' . $invitation['receiver_name'];
        $to_email = $invitation['receiver_email'];
        $data = [
            'invitation' => $invitation,
        ];
        Mail::send(
            'templates.mail.invitation',
            $data,
            function($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)
                        ->subject('Invitation to join Offlist');
                $message->from('info@offlist.de', 'Offlist');
            }
        );
    }

}
