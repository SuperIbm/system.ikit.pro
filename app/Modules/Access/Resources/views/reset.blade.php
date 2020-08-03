@extends('tpl.mail.index')

@section('header')
    That was you, wasn't it, {{ $name }}?
@endsection

@section('content')
    Hi {{ $name }}. When your password is changed, we'll let you know. If you didn't make this change, you should <a href="{{ $site }}contact-us">contact customer</a> service or <a href="{{ $site }}forget">reset your password</a>.
@endsection

@section('button')
    <a class="button" href="{{ $site }}">
        Go to the site
    </a>
@endsection
