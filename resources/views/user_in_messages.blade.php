@extends('layouts.main')

@section('title')
	My offers
@stop

@section('content')



@include('partials.user_messages_menu', ['offers' => $offers, 'other' => $other])


<div class="user-cp-form user-cp-my-offers panel panel-default col-md-7">
<div class="panel-heading">
	@if($other['current'])
		{{--maybe add how much left for the post to end--}}
		{{--<div class="messages-post-sideinfo">--}}
			{{--<span><b>{{trans('word.your_price')}} :</b> {{$offer->post->price}}</span>--}}
		{{--</div>--}}
		<div class="messages-post-info">
			<div class="messages-post-info-img"><img src="/{{$offer->post->primary_photo_path}}" /></div>
			<div class="messages-post-info-offer">
				<span>{{$offer->post->title}}</span>
				<br />{{trans('word.received_an_offer_for', ['offeree' => $offer->offeree->profile_name, 'amount' => $offer->amount])}}. {{$offer->created_at->diffForHumans()}}
				<br />{{trans('word.the_price_chosen_by_you_is', ['price' => $offer->post->price])}}</div>

		</div>
		@else
		<h4>{{trans("word.in_messages_and_offers")}}</h4>
	@endif
</div>
<div class="panel-body">
	@if($other['current'])
	<div class="messages-post-form">
		<form class="form-inline" method="POST" action="{{route('userInMessagesPost', $offer->id)}}">
			{{csrf_field()}}
			@foreach($messages as $message)
				<div class="message-element @if($message->sender_id == Auth::id()) message-mine @else message-theirs @endif">
					{{$message->message}}
				</div>
			@endforeach
			<div class="messages-post-elements">
				<input type="text" class="form-control" name="userMessage" placeholder="Enter your message" style="float: right;" />
				<button class="btn btn-primary" type="submit" style="float: left;">Send</button>
			</div>
		</form>
	</div>
	@endif
</div>
</div>
@stop
