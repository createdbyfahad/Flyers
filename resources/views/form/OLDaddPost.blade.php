@extends('layouts.main')

@section('title'){{trans('action.postAnAdIn')}} {{$category_child}}@stop
@section('scripts.header')
<link rel="stylesheet" href="/css/dropzone.css">
@stop
@section('content')
	<h3>{{trans('action.postAnAdIn')}}: {{$category}} > {{$category_child}}</h3>
	<h5><a href="{{route('createPost')}}">{{trans('action.changeCategory')}}</a></h5>
	<hr />
	<div class="col-md-7">
		<form class="form-horizontal" method="POST" role="form" action="/p/add/{{$category_code}}/save">
			<div class="form-group">
				<label class="col-md-2" for="postTitle">{{trans('word.postTitle')}}</label>
				<input type="text" class="form-control col-md-10" name="postTitle" required="required" value="{{old('postTitle')}}">
			</div>
		
			<div class="form-group">
				<label class="col-md-2" for="postPrice">{{trans('word.price')}}</label>
				<div class="form-inline">
					<div class="input-group col-md-3">
						<input type="text" class="form-control numbersOnly" name="postPrice" id="fieldPrice" value="{{old('postPrice')}}">
						<div class="input-group-addon">{{trans('word.rs')}}</div>
					</div>
					<label>
						<input type="checkbox" name="postPriceCheck" onclick="disable_field('#fieldPrice')">
						{{trans('word.noPrice')}}
					</label>
				</div>
			</div>
			@if($attr)
				@foreach($attr as $name => $field)
					<div class="form-group">
						<label class="col-md-2">{{$name}}</label>
						{!! $field !!}
					</div>
				@endforeach
			@endif
			<div class="form-group">
				<label class="col-md-2" for="postBody">{{trans('word.postBody')}}</label>
				<textarea name="postBody" id="input" class="form-control col-md-10" rows="8" required="required">{{old('postBody')}}</textarea>
			</div>
			<button type="submit" class="btn btn-primary">{{trans('action.step2Photos')}}</button>
			{!! csrf_field() !!}
		</form>
	</div>
	@include('partials.formErrors')
@stop
@push('scripts.footer')
	<script src="/js/jquery.numeric.min.js"></script>
	<script src="/js/dropzone.js"></script>
	<script type="text/javascript">$('.numbersOnly').numeric();</script>
@endpush