@extends('templates.mail.layout')

{{-- content --}}
@section('heading')
  Hello admin,
@endsection

@section('content')
  A user has created a free offer and also registered a free account on our Offlist system.<br />
  The user information are below: <br />
  <br />
  <strong>Name:</strong> {{ $name }}<br />
  <strong>Email:</strong> {{ $email }}<br />
  <strong>Phone:</strong> {{ $phone }}<br />
  <strong>Company:</strong> {{ $company }}<br />
  <strong>Website:</strong> {{ $website }}<br />
  <strong>Address:</strong> {{ $address }}<br />
  <strong>City:</strong> {{ $city }}<br />
  <strong>Zipcode:</strong> {{ $zip_code }}<br />
  <br />
  Please go to the Offlist Admin area to review.
@endsection
