@extends('templates.mail.layout')

{{-- content --}}
@section('heading')
   Hello {{ $name }},
@endsection

@section('content')
  We thank you for placing this offer.<br />
  After confirming your email address and choosing a password, your offer will be checked and released within 48h. You can edit it at any time in your offer area.<br />
  <br />
  Please check your inbox for your email address now. If you don't receive a confirmation email within the next 5 minutes, please check your email address by clicking on "Back" below.<br />
  <br />
  We wish you good luck with the sale.
  If you have any questions, you can reach your contact person here:<br />
  <br />
  Offlist Team<br />
  Email: <a href="mailTo:contact@offlist.de">contact@offlist.de</a><br />
  Mobile: <a href="tel:+4930901820">+4930901820</a><br/>
@endsection
