@extends('layouts.base')

@section('title')
    <title>StoreFront</title>
@endsection

@section('content')

    <h1 class="text-success">Testing bootstrap</h1>

    @if (Auth::User())

        <h1>{{ Auth::User()->name }}</h1>

        <hr>

        <h2>{{ Auth::User()->email }}</h2>

        <hr>

        <img src="{{ Auth::User()->profile_picture }}" alt="{{ Auth::User()->name }}">

        <a href="{{ url('/auth/log-out') }}">Log out</a>

    @endif


@endsection
