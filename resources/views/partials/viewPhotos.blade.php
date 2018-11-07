<div class="photos-viewer col-md-12">
	@foreach($post->photos as $photo)
		@if($photo->primary === 1 || count($post->photos) == 1)
			<div class="viewPhoto active primary" data-id="{{$photo->id}}" data-name="{{$photo->photo_name}}">
				<img class="single-photo-view" src="/{{$photo->photo_path}}" />
			</div>
		@else
			<div class="viewPhoto" data-id="{{$photo->id}}" data-name="{{$photo->photo_name}}"></div>
		@endif
	@endforeach
</div>

<div class="photos-controller col-md-12">
@foreach($post->photos as $photo)

		<a href="{{$photo->photo_path}}" data-id="{{$photo->id}}">
			<div style="height: 80px; width: 80px; background: #ffffff url('{{url($photo->thumbnail_path)}}') no-repeat center;" class="controller-single-photo @if($photo->primary === 1)primary selected @endif"></div>
		</a>

@endforeach
</div>
@if(isset($post->owner))
	<a id="primary-selected-photo" class="btn btn-default photos-controller-primary">Make as offer cover</a>
	<a id="delete-selected-photo" class="btn btn-danger photos-controller-delete">Delete selected photo</a>
@endif
@push('scripts.footer')
<script>
	$('.photos-controller a .controller-single-photo').hover(function(e){
		var photoID = $(this).parent().attr('data-id');
		var photoDiv = $('.photos-viewer .viewPhoto[data-id ="'+photoID+'"');
		if (photoDiv.find('img').length == 0){ // photo is not loaded
			var photoName = photoDiv.attr('data-name');
			var photoSrc = '/photos/'+photoName;
			photoDiv.append('<img class="single-photo-view" src="'+photoSrc+'" />');
		}
		//swap when image is loaded.
		var imgElem = photoDiv.find(">:first-child");
		if(!imgElem.prop('complete')) {
            imgElem.on('load', function () {
                swapPhotoIn(photoDiv);
            });
        }else{
            swapPhotoIn(photoDiv);
		}
		return false;
	}, swapPhotoOut);
	$('.photos-controller a .controller-single-photo').on('click', function(e){
		var photoID = $(this).parent().attr('data-id');
		var photoDiv = $('.photos-viewer .viewPhoto[data-id ="'+photoID+'"');
		$('.photos-controller a').find('.selected').removeClass('selected');
		$('.photos-viewer').find('div.primary').removeClass('primary');
		photoDiv.addClass('primary');
		$(this).addClass('selected');
		return false;

	});
	function swapPhotoIn(div)
	{
		$('.photos-viewer').find('.active').removeClass('active');
		div.addClass('active');
	}

	function swapPhotoOut()
	{
		$('.photos-viewer').find('.active').removeClass('active');
		$('.photos-viewer').find('.primary').addClass('active');
	}
</script>
@endpush
