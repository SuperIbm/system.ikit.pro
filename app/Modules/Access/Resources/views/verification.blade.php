@extends('tpl.mail.index')

@section('header')
    Please verify your email address
@endsection

@section('content')
    Please click the button below to verify your email address.
@endsection

@section('button')
    <a class="button" href="{{ $site }}verified/{{ $id }}?code={{ $code }}">
        Verify email address
    </a>
@endsection
