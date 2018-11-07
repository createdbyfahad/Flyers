@extends('layouts.main')

@section('title') {{$post->title}} @stop
@section('content')
    @section('scripts.header')
        <link rel="stylesheet" href="/css/new_post.css" />
    @stop
    @include('partials.new_post_progress_bar')
    @include('partials.post_stats_activate')
	@include('posts.singleView')
@stop
