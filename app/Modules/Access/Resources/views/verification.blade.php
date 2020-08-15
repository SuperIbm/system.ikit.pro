@extends('tpl.mail.index')

@section('header')
    {{ trans('access::views.verification.header') }}
@endsection

@section('content')
    {{ trans('access::views.verification.content') }}
@endsection

@section('button')
    <a class="button" href="{{ $site }}verified/{{ $id }}?code={{ $code }}">
        {{ trans('access::views.verification.button') }}
    </a>
@endsection
