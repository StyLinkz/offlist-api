@extends('templates.mail.layout')

{{-- content --}}
@section('heading')
   Hello {{ $invitation['receiver_prename'] . ' ' . $invitation['receiver_name'] }},
@endsection

@section('content')
    You have received an invitation to join the exclusive Offlist network from {{ $invitation['sender_name'] }}.<br>
    Please use the code below to register an account in the app.
@endsection

@section('mobile-label')
    <strong>{{ $invitation['code'] }}</strong>
@endsection

@section('content2')
    If you don't want to join the Offlist network, you don't have to do anything.<br><br>
    <em>This code will be valid for 14 days.</em>
@endsection
