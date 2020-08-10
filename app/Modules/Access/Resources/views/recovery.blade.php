@extends('tpl.mail.index')

@section('header')
    {{ trans('views.recovery.header') }}
@endsection

@section('content')
    {{ trans('views.recovery.content') }}
@endsection

@section('button')
    <a class="button" href="{{ $site }}forget/reset/{{ $id }}?code={{ $code }}">
        {{ trans('views.recovery.button') }}
    </a>
@endsection
