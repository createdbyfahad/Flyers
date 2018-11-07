@extends('layouts.main')

@section('title') {{$post->title}} @stop
@section('content')
	@include('posts.singleView')
@stop
