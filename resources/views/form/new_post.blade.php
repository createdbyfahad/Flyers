@extends('layouts.main')

@section('scripts.header')
	<link rel="stylesheet" href="/css/bootstrap-slider.min.css" />
	<link rel="stylesheet" href="/css/new_post.css" />
@stop

@section('title')
	Add a Post
@stop

@section('content')
	@include('partials.new_post_progress_bar', compact($progress_bar))
<div class="new-post-form panel panel-default col-md-12">
	<div class="panel-heading">
		<h2>{{trans("forms.add_new_post")}}</h2>
	</div>
	<div class="panel-body">
		<form action="/p/add/info/{{$post->id}}" method="POST" id="catForm">
			<div class="form-group row">
				<label for="newPostCategory" class="col-sm-2 control-label">Category</label>
				<div class="col-sm-10">
					<select id="newPostCategory" name="category" class="form-control" required="required">
						@foreach($categories as $category)
							<option value="{{$category->id}}">{{$category->name}}</option>
						@endforeach
					</select>
					<span id="helpBlock" class="help-block">A block of help text that breaks onto a new line and may extend beyond one line.</span>
				</div>
			</div>
			<div class="form-group row">
				<label for="newPostTitle" class="col-sm-2 control-label">Title</label>
				<div class="col-sm-10">
					<input name="title" class="form-control" id="newPostTitle" placeholder="Title" value="{{oldOrPost($post->title, 'title')}}">
					<span id="helpBlock" class="help-block">A block of help text that breaks onto a new line and may extend beyond one line.</span>
				</div>
			</div>

			<div class="form-group row">
				<label for="newPostPrice" class="col-sm-2 control-label">Price</label>
				<div class="col-sm-2">
					<div class="input-group">
						<input name="price" class="form-control numbersOnly" id="newPostPrice" placeholder="Price" @if(oldOrPost($post->price, 'price')) value="{{oldOrPost($post->price, 'price')}}@endif">
						<span class="input-group-addon">SAR</span>
					</div>
				</div>
                <label>
                    <input type="checkbox" name="postPriceCheck" onclick="disable_field('#newPostPrice')">
                    {{trans('word.noPrice')}}
                </label>
				<span id="helpBlock" class="help-block col-sm-8">A block of help text that breaks onto a new line and may extend beyond one line.</span>
			</div>

			<div class="form-group row">
				<label for="newPostDesc" class="col-sm-2 control-label">Description</label>
				<div class="col-sm-8">
					<textarea name="description" id="newPostDesc" class="form-control" rows="8" required="required">{{oldOrPost($post->body, 'description')}}</textarea>
				</div>
				<span id="helpBlock" class="help-block col-sm-2">A block of help text that breaks onto a new line and may extend beyond one line.</span>
			</div>

			<div class="form-group row">
				<label for="newPostDesc" class="col-sm-2 control-label">Status</label>
				<div class="col-sm-10">
					<div class=" col-md-6">
					<input name="wear" class="form-control slider" id="newPostStatus" data-provide="slider"
						   data-slider-ticks="[1, 2, 3, 4, 5]"
						   data-slider-ticks-labels='[ "{{trans('post.wear_1')}}", "{{trans('post.wear_2')}}", "{{trans('post.wear_3')}}", "{{trans('post.wear_4')}}", "{{trans('post.wear_5')}}"]'
						   data-slider-min="1"
						   data-slider-max="5"
						   data-slider-step="1"
						   data-slider-value="@if(oldOrPost($post->wear, 'wear')){{oldOrPost($post->wear, 'wear')}}@else 3 @endif"
						   data-slider-tooltip="hide"
						   data-slider-id="newPostSlider">
					<span id="statusSlider1" class="help-block hide">{{trans('post.wear_1_desc')}}</span>
					<span id="statusSlider2" class="help-block hide">{{trans('post.wear_2_desc')}}</span>
					<span id="statusSlider3" class="help-block show">{{trans('post.wear_3_desc')}}</span>
					<span id="statusSlider4" class="help-block hide">{{trans('post.wear_4_desc')}}</span>
					<span id="statusSlider5" class="help-block hide">{{trans('post.wear_5_desc')}}</span>
					</div>
				</div>
			</div>

			<hr />

			<div class="form-group row">
				<label for="newPostLocation" class="col-sm-2 control-label">Location</label>
				<div class="col-sm-3">
					<select id="newPostLocation" name="location" class="form-control changeMap" required="required">
						@foreach($districts as $district)
							<option value="{{$district->id}}" data-lat='{{$district->lat}}' data-lng='{{$district->ling}}'>{{$district->name}}</option>
						@endforeach
					</select>
					<span id="helpBlock" class="help-block">A block of help text that breaks onto a new line and may extend beyond one line.</span>
				</div>
				<div class="col-sm-7">
					<div id="map"></div>
					<input type="hidden" id="latVal" name="lat" value="" />
					<input type="hidden" id="lngVal" name="lng" value="" />
					{{csrf_field()}}
				</div>
			</div>

			<div class="form-group row">
				<div class="col-sm-offset-2 col-sm-10">
					<div class="checkbox">
						<label>
							<input type="checkbox"> Remember me
						</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-primary btn-lg">Submit</button>
				</div>
			</div>
		</form>
		@include("partials.formErrors")
	</div>
</div>
@stop
@push('scripts.footer')
<script src="http://maps.googleapis.com/maps/api/js?key=GOOGLE_API_KEY&language=ar"></script>
<script src="{{asset('js/bootstrap-slider.min.js')}}"></script>
<script>
//Choose category page
$('#inputCategory').on('change', function(e){
	console.log(e);
	var cat_id = e.target.value;
	//ajax
	$.get('/ajax/category?cat_id='+ cat_id, function(data){
		//success data
		$('#subCategory').empty();
		$.each(data, function(index, subcatObj){
			$('#subCategory').append('<option value="'+subcatObj.code+'">'+subcatObj.name+'</option>');
		});
	});
});
$('#CategoryNextStep').on('click', function(){
	//if the first menu hasn't changed return false
	if($("#subCategory option[value='choose']").length > 0) return false;
	var code = $('#subCategory').val();
	var url = '/p/add/' + code;
	$('#catForm').attr('action', url);
	
});
$('#noLocation').change(function(){
	if($(this).is(':checked')){
		$('.changeMap').prop('disabled', true);
	} else {
		$('.changeMap').prop('disabled', false);
	}
})
$('#districtPickerParent').on('change', function(e){
	var districtParent = e.target.value;
	//ajax
	$.get('/ajax/district?parent='+ districtParent, function(data){
		//success data
		$('#districtPicker').empty();
		$.each(data, function(index, subcatObj){
			$('#districtPicker').append('<option data-lat="'+subcatObj.lat+'" data-lng="'+subcatObj.ling+'" value="'+subcatObj.id+'">'+subcatObj.name+'</option>');
		});
	});
});

var map;
function initMap() {
	map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 21.540372, lng: 39.172223},
        zoom: 12,
        componentRestrictions: {country: "SA"},
        scrollwheel: false,
        navigationControl: false,
        mapTypeControl: false,
        scaleControl: false,
        zoomControl: false,
        disableDoubleClickZoom: true,
        clickableIcons: false,
        fullscreenControl: false,
        streetViewControl: false,
    });
    var circle = new google.maps.Circle({
        strokeColor: '#173bff',
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: '#1d46ff',
        fillOpacity: 0.35,
        map: map,
        center:  {lat: 21.635153, lng: 39.130808},
        radius: Math.sqrt(500) * 100
    });

	$('.changeMap').on('change', function(){
		var selected = $(this).find('option:selected');
		var position = new google.maps.LatLng(selected.data('lat'), selected.data('lng'));
		map.panTo(position);
		positionField(false);
	});

	map.addListener('center_changed', function(e){
        circle.setCenter(map.getCenter());
        positionField(map.getCenter());
	});
};
function positionField(position) {
	if(!position){
		$('#latVal').val(null);
		$('#lngVal').val(null);
	}else{
		$('#latVal').val(position.lat());
		$('#lngVal').val(position.lng());
	}
}
google.maps.event.addDomListener(window, 'load', initMap);

$('.slider').on('change', function (val) {
	$('#statusSlider' + val.value.oldValue).removeClass('show');
	$('#statusSlider' + val.value.oldValue).addClass('hide');
    $('#statusSlider' + val.value.newValue).removeClass('hide');
    $('#statusSlider' + val.value.newValue).addClass('show');

});
</script>
<script src="/js/jquery.numeric.min.js"></script>
<script type="text/javascript">$('.numbersOnly').numeric();</script>
@endpush