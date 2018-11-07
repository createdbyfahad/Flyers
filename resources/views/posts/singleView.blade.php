<div class="col-md-9 post-panel post-main">
	<div class="post-gallery clearfix">
		@if($post->photos()->exists()) @include('partials.viewPhotos') @endif
	</div>
	<div class="post-info">
		<div class="post-head">
			<span class="post-title">{{$post->title}}</span><br />
			<span class="post-title-category"><a href="{{$post->category->url}}">{{$post->category->name}}</a></span>
			<div class="post-title-info">
				<span>
					{{trans('word.posted')}}: {{$post->created_at->diffForHumans()}}
				</span>
				@if($post->repost_at)
					<span class="sideInfoElement ">
						{{trans('word.rePosted')}}: {{$post->repost_at->diffForHumans()}}
					</span>
				@endif
			</div>
			{{--<span><h2 class="title">@if($post->price != 0) - {{$post->price}} {{trans('word.rs')}}@endif--}}
			{{--@if($post->district_id > 0)--}}
				{{--<small>{{trans('word.in')}} <a href="/search?d={{$post->district_id}}" title="{{trans('action.exploreDistrict')}}"><span class="focus">{{$post->district->name}}</span></a></small>--}}
			{{--@endif</h2></span>--}}
		</div>
		<div class="post-body">
			{{--<div class="postSideInfo col-md-3 pull-left">--}}
				{{--@if(!is_null($post->lat))--}}
					{{--<a target="_blank" title="{{trans('action.openInLargerWindow')}}" href="http://maps.google.com/?q={{$post->lat}},{{$post->lng}}">--}}
						{{--<img src="https://maps.googleapis.com/maps/api/staticmap?size=300x300&markers=color:red|{{$post->lat}},{{$post->lng}}&zoom=12&key=GOOGLE_API_KEY" />--}}
					{{--</a>--}}
				{{--@endif--}}
				{{--@if($post->attr)--}}
					{{--<div class="postAttrs">--}}
						{{--@foreach($post->attr as $field)--}}
							{{--@if(count($field->value) == 1 AND !is_array($field->value))--}}
								{{--<span class="sideInfoElement">{{$field->name}}: <strong>{{$field->value}}</strong></span>--}}
							{{--@else--}}
								{{--@foreach($field->value as $option)--}}
									{{--<span class="sideInfoElement">{{$field->name}}: <strong>{{$option}}</strong></span>--}}
								{{--@endforeach--}}
							{{--@endif--}}
						{{--@endforeach--}}
					{{--</div>--}}
				{{--@endif--}}

			<div class="post-description">
				<span>{{trans('word.desc')}}</span>
				<p>{!! nl2br($post->body) !!}</p>
			</div>
		</div>
	</div>
</div>
<div class="col-md-3 post-side-info">
	<div class="post-panel offer-panel">
		<div class="post-panel-head">{{trans('word.asking_for')}}</div>
		<div class="post-panel-price">{{$post->bPrice}}</div>
		@if(!isset($post->is_owner))
			<a href="#test" rel="leanModel" id="offer-price-trigger" class="btn post-side-btn post-offer-btn">{{trans('word.offer_price')}}</a>
			<a href="#" class="btn post-side-btn post-msg-btn">{{trans('word.send_message')}}</a>
		@endif
	</div>
	<div class="post-panel location-panel">
		<div class="post-panel-head">{{trans('word.location_in')}} {{$post->district->name}}</div>
		@if(isset($post->map_url))
			{{--<a target="_blank" title="{{trans('action.openInLargerWindow')}}" href="#">--}}
				<img class="post-info-map" src="{{$post->map_url}}" />
			{{--</a>--}}
		@endif
	</div>
	<div class="post-panel wear-panel">
		<div class="post-panel-head">{{trans('word.product_wear')}}</div>
		<div class="post-panel-wear">{!! $post->wear_description !!}</div>
	</div>
	<div class="post-panel seller-panel">
		<div class="post-panel-head">{{trans('word.seller')}}</div>
		<img class="post-seller-photo" src="{{$post->user->profilePic}}" />
		<div class="post-seller-name">{{$post->user->profileName}}</div>
		<div class="post-seller-rating"><img src="https://banner2.kisspng.com/20180426/ziq/kisspng-a-long-walk-to-water-united-states-television-revi-stars-5ae1f8d5de0995.8224056915247587419095.jpg" /><small>4 {{trans('word.reviews')}}</small></div>
	</div>
	@if(isset($post->is_owner))
		<div class="post-panel manage-panel">
			<div class="post-panel-head">Manage Offer</div>
			<div class="post-panel-views">2500 views</div>
			<a href="{{route('editPost', $post->id)}}" class="btn btn-primary post-side-btn">Edit Offer</a>
			<a href="#" class="btn btn-primary post-side-btn">Bumpify <br /><small>2 out of 3</small></a>
		</div>
	@endif
</div>

<div id="test" class="panel panel-dialog" style="display: none;">
	<div class="panel-heading">
		<div class="panel-title">Offer a price</div>
	</div>
	<div class="panel-body">
		@if(Auth::check())
			<form method="POST" action="{{route('postOffer', $post->id)}}" >
				{{ csrf_field() }}
			<h3>
				Enter a price:
			</h3>
			<input type="text" name="offer_price" />
			<h5>Need to send a message?</h5> <textarea name="offer_message"></textarea>
				<button type="submit" class="btn btn-primary">Offer</button>
			</form>
		@else
			<form class="form-horizontal" method="POST" action="{{ route('register') }}">
				{{ csrf_field() }}

				<div class="form-group">
					<label for="name" class="col-md-4 control-label">{{trans('auth.full_name')}}</label>

					<div class="col-md-6">
						<input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
					</div>
				</div>

				<div class="form-group">
					<label for="phone" class="col-md-4 control-label">{{trans('auth.phone')}}</label>
					<div class="col-md-6">
						<input id="phone" type="phone" class="form-control" name="phone" value="{{ old('phone') }}" required>
					</div>
				</div>

				<div class="form-group">
					<label for="email" class="col-md-4 control-label">{{trans('auth.email')}} ({{trans('auth.optional')}})</label>
					<div class="col-md-6">
						<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">
					</div>
				</div>

				<div class="form-group">
					<label for="password" class="col-md-4 control-label">{{trans('auth.password')}}</label>
					<div class="col-md-6">
						<input id="password" type="password" class="form-control" name="password" required>
					</div>
				</div>
				<div class="form-group">
					<label for="password-confirm" class="col-md-4 control-label">{{trans('auth.password_confirm')}}</label>

					<div class="col-md-6">
						<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-6 col-md-offset-4">
						<button type="submit" class="btn btn-primary">
							{{trans('auth.register')}}
						</button>
					</div>
				</div>
			</form>

		@endif
	</div>
</div>

@push('scripts.footer')
	<script type="text/javascript" src="/js/jquery.leanModal.min.js"></script>
	<script>
        $("#offer-price-trigger").leanModal();
	</script>
@endpush