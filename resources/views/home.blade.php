@extends('base')

@section('title', 'Home')

@section('content')
    <h1 class="text-4xl font-bold">Home</h1>
    <a href="{{ route('posts.index') }}">Annonces</a>

@endsection