@extends('templates.mail.layout')

{{-- content --}}
@section('heading')
  Hello {{ $name }},
@endsection

@section('content')
  Congratulation! Your account and your offer have been approved by our Offlist team.<br />
  You can login with the following credentials:<br />
  <br />
  Email: {{ $email }}<br />
  Password: <strong>{{ $password }}</strong><br />
  <br />
  After you log in successfully, please change your password immediately.
@endsection
