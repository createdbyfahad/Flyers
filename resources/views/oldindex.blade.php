@extends('layouts.main_active')

@section('title')
	test
@stop

@section('content')
	<div class="categories col-md-12">
		@include('partials.categories')
	</div>
	
	<div class='lastPosts'>
	<h2>{{trans('word.postsShow')}}</h2>
		@foreach($lastPosts as $post)
			<div class="row singleTitle col-md-12 list-inline" data-id='{{$post->id}}'>
				<h4>
					<span class="sideInfoDate">{{$post->created_at->format('d M')}}</span>
					<a href="{{postURL($post->id, $post->slug)}}">{{$post->title}}</a>
					<span class="sideInfo">
						@if($post->price > 0) <span class="price">{{$post->price}} {{trans('word.rs')}}</span> @endif
						@if($post->hasPhoto()) - <span class='attention'>{{trans('word.photos')}}</span> @endif
					</span>
				</h4>
			</div>
		@endforeach
	</div>
	@if($lastPostsCats) @include('partials.carousal') @endif
@stop