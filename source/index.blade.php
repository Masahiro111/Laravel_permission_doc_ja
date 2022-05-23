@extends('_layouts.main')

@section('body')

<h2>Blog</h2>

<ul>
    @foreach ($posts as $post)
    <li><a href="{{ $post->getUrl() }}">{{ $post->title }}</a></li>
    @endforeach
</ul>

@endsection