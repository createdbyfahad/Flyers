@extends('layouts.main_active')

@section('title')
	Flyers Project
@stop

@section('content')
	<div class="browse-cat">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">{{trans('word.categories')}}</h3>
			</div>
			<ul class="panel-body">
				@foreach($categories as $category)
					<a href="{{$category->url}}"><li>{{$category->name}}</li></a>
				@endforeach
			</ul>
		</div>
	</div>
	<div class='main-gallery'>
		<div class="gallery-nav">

		</div>
		<div class="grid">
		@foreach($lastPosts as $post)
			<div class="post-box panel panel-default grid-item">
				<a href="{{$post->url}}"><div style="height: {{$post->thumbnail_height}}px; width:100%; background-image: url('{{$post->primary_photo_path}}');"></div></a>
				<div class="post-box-body">
					<a href="{{$post->url}}"><span class="post-box-title">{{$post->title}}</span></a>
					<div class="post-box-price">{{$post->bPrice}}</div>
					<div class="post-box-location">يبعد 1 كيلو - {{$post->district->name}}</div>
				</div>
				<div class="post-box-owner">
					<img class="post-box-owner-pic img-circle" src="{{$post->user->profile_pic}}" />
					{{$post->user->profileName}}</div>
			</div>
			{{--<div class="row singleTitle col-md-12 list-inline" data-id='{{$post->id}}'>--}}
				{{--<h4>--}}
					{{--<span class="sideInfoDate">{{$post->created_at->format('d M')}}</span>--}}
					{{--<a href="{{postURL($post->id, $post->slug)}}">{{$post->title}}</a>--}}
					{{--<span class="sideInfo">--}}
						{{--@if($post->price > 0) <span class="price">{{$post->price}} {{trans('word.rs')}}</span> @endif--}}
						{{--@if($post->hasPhoto()) - <span class='attention'>{{trans('word.photos')}}</span> @endif--}}
					{{--</span>--}}
				{{--</h4>--}}
			{{--</div>--}}
		@endforeach
		</div>
	</div>
	{{--@if($lastPostsCats) @include('partials.carousal') @endif--}}
@stop

@push('scripts.footer')
	<script src="{{ asset('js/masonry.pkgd.min.js') }}"></script>
	<script>
		$('.grid').masonry({
            // options
            itemSelector: '.grid-item',
            columnWidth: 210,
            isRTL: true,
            originLeft: false
        });
	</script>
@endpush