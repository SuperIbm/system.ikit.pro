@extends('tpl.mail.index')

@section('header')
    {{ trans('views.reset.header',
        [
        'name' => $name
        ]
    ) }}
@endsection

@section('content')
    {{ trans('views.reset.content',
        [
        'name' => $name,
        'url' => $site.'contact-us'
        ]
    ) }}
@endsection

@section('button')
    <a class="button" href="{{ $site }}">
        {{ trans('views.reset.button') }}
    </a>
@endsection
