@extends('tpl.mail.index')

@section('header')
    {{ trans('access::views.reset.header',
        [
        'name' => $name
        ]
    ) }}
@endsection

@section('content')
    {{ trans('access::views.reset.content',
        [
        'name' => $name,
        'url' => $site.'contact-us'
        ]
    ) }}
@endsection

@section('button')
    <a class="button" href="{{ $site }}">
        {{ trans('access::views.reset.button') }}
    </a>
@endsection
