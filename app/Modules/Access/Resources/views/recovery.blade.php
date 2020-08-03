@extends('tpl.mail.index')

@section('header')
    Recovery the password of the user
@endsection

@section('content')
    Please click the button below to recovery your password.
@endsection

@section('button')
    <a class="button" href="{{ $site }}forget/reset/{{ $id }}?code={{ $code }}">
        Reset the password
    </a>
@endsection
