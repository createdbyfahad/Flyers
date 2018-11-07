<div class="postMain view col-md-8">
	<div class="postTitle">
		<span><h2 class="title">{{$post->title}}@if($post->price != 0) - {{$post->price}} {{trans('word.rs')}} @endif</h2></span>
		<div class="row titleInfo">
			@if($post->attr)
				@foreach($post->attr as $field)
					<span><h4>{{$field->name}}: </h4>
						@if(count($field->value) == 1 AND !is_array($field->value))
							<p>{{$field->value}}</p>
						@else
							<ul>
							@foreach($field->value as $value)
								<li>{{$value}}</li>
							@endforeach
							</ul>
						@endif
					</span>
				@endforeach
			@endif
		</div>
	</div>
	<hr />
	<div class="postBody">
		<p>{!! nl2br($post->body) !!}</p>
	</div>
</div>