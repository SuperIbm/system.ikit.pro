@extends('tpl.mail.index')

@section('header')
    {{ trans('views.verification.header') }}
@endsection

@section('content')
    {{ trans('views.verification.content') }}
@endsection

@section('button')
    <a class="button" href="{{ $site }}verified/{{ $id }}?code={{ $code }}">
        {{ trans('views.verification.button') }}
    </a>
@endsection
