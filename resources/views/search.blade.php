@extends('layouts.main_active')

@section('title') {{trans('search')}} @stop
@section('content')
	<div class="col-md-2 searchPanels">
	<div class="panel panel-default">
		<div class="panel-heading">fdsafas</div>
		<div class="panel-body">
			<div class="searchgroup">
				
			</div>
		</div>
	</div>
	</div>
	<div class="col-md-10 searchBody">
	@foreach($search as $post)
		<h4><a href="{{postURL($post['_id'], $post['_source']['slug'])}}">{{$post['_source']['title']}}</a></h4>
	@endforeach
	</div>
@stop
