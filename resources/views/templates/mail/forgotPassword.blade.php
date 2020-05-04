@extends('templates.mail.layout')

{{-- content --}}
@section('heading')
    Reset your password
@endsection

@section('content')
    Need to reset your password? No problem. Just copy the code below to the app to continue.
@endsection

@section('mobile-label')
    <strong>{{ $user->reset_password_token }}</strong>
@endsection

@section('content2')
    If you didn't request to change your password, you don't have to do anything. So that's easy.<br><br>
    <em>This code will be valid in 1 hour.</em>
@endsection

@section('foot-note')
    If you did not request a password reset on <a href="{{ env('APP_URL') }}" style="color:#787878">offlist.de</a> simply ignore this e-mail.
@endsection
