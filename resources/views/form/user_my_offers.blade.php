@extends('layouts.main')

@section('title')
	My offers
@stop

@section('content')


@include('partials.user-cp-menu', ['current' => 'my_offers'])
<div class="user-cp-form user-cp-my-offers panel panel-default col-md-8">
	<div class="panel-heading">
		<h4>{{trans("word.my_offers")}}</h4>
	</div>
	<div class="panel-body">
		{{--<div id="user-my-offers" role="tablist" aria-multiselectable="true">--}}
			{{--@if($posts->count() > 0)--}}
				{{--@foreach($posts as $post)--}}
					{{--<div class="panel panel-default">--}}
						{{--<div class="panel-heading user-my-offers-post-preview" role="tab" id="user-my-offers-no{{$post->id}}">--}}
							{{--<div class="my-offers-img-preview"><img src="/{{$post->primary_photo_path}}" /></div>--}}
							{{--<a data-toggle="collapse" data-parent="#user-my-offers" href="#user-my-offers-content-no{{$post->id}}" aria-expanded="false" aria-controls="user-my-offers-content-no{{$post->id}}">--}}
								{{--<h4 class="my-offers-title">--}}
									{{--{{$post->title}}--}}
								{{--</h4>--}}
							{{--</a>--}}
							{{--<div class="my-offers-actions">Total Views: 800. <a class="btn btn-primary" href="{{route('confirmPost', $post->id)}}">Edit</a></div>--}}
						{{--</div>--}}
						{{--<div id="user-my-offers-content-no{{$post->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="user-my-offers-no{{$post->id}}">--}}
							{{--<div class="panel-body">--}}
								{{--{{$post->body}}--}}
							{{--</div>--}}
						{{--</div>--}}
					{{--</div>--}}
				{{--@endforeach--}}
			{{--@endif--}}
		{{--</div>--}}

		@if($posts->count() > 0)
			<table class="table table-condensed" style="border-collapse:collapse;">
				<thead>
				<tr>
					<th></th>
					<th>Title</th>
					<th>Price</th>
					<th>Views</th>
					<th>Time Left</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				@foreach($posts as $post)
					<tr data-toggle="collapse" data-target="#user-my-offers-content-no{{$post->id}}" class="accordion-toggle">
						<td class="my-offers-img-preview"><img src="/{{$post->primary_photo_path}}" /></td>
						<td>{{$post->title}}</td>
						<td>{{$post->bPrice}}</td>
						<td class="text-success">15000 view</td>
						<td class="text-error"> 3 days</td>
						<td class="text-success"><a class="" href="{{route('confirmPost', $post->id)}}">Edit</a></td>
					</tr>

					<tr >
						<td colspan="6" class="hiddenRow">
							<div class="collapse my-offers-content" id="user-my-offers-content-no{{$post->id}}">
								@foreach($post->offers as $offer)
									{{$offer->amount}}
								@endforeach
							</div>
						</td>
					</tr>

						{{--@if($post->offers->count() == 0)--}}
							{{--<tr class="collapse my-offers-content hiddenRow" id="user-my-offers-content-no{{$post->id}}"><td colspan="6" class=""></td></tr>--}}
						{{--@else--}}
							{{--@foreach($post->offers as $offer)--}}
								{{--<tr class="collapse my-offers-content hiddenRow" id="user-my-offers-content-no{{$post->id}}">--}}
								{{--<td class=""></td>--}}
								{{--<td>{{$post->title}}</td>--}}
								{{--<td>{{$offer->amount}}</td>--}}
								{{--<td class="text-success">15000 view</td>--}}
								{{--<td class="text-error"> 3 days</td>--}}
								{{--<td class="text-success"><a class="" href="{{route('confirmPost', $post->id)}}">Edit</a></td>--}}
								{{--</tr>--}}
							{{--@endforeach--}}
						{{--@endif--}}


				@endforeach
				</tbody>
			</table>
		@endif

	</div>
</div>
@stop
