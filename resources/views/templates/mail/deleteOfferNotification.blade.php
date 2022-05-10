@extends('templates.mail.layout')

{{-- content --}}
@section('heading')
   Hello {{ $application['sender_prename'] . ' ' . $application['sender_name'] }},
@endsection

@section('content')
  The offer you asked before was deleted by the owner.
@endsection
