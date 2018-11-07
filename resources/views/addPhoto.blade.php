@extends('layouts.main')

@section('title')Add Photo @stop
@section('scripts.header')
	<link rel="stylesheet" href="/css/dropzone.css">
	<link rel="stylesheet" href="/css/new_post.css" />
@stop
@section('content')
	@include('partials.new_post_progress_bar', compact($progress_bar, ['post_id' => $post->id]))
<div class="new-post-photos panel panel-default col-md-12">
	<div class="panel-heading">
		<h2>{{trans("forms.add_photos")}}</h2>
	</div>
	<div class="panel-body">
	<div class="col-md-8">
		@include('partials.viewPhotos')
		<hr />
		<h2>Add You Photos:</h2>
		<form id="addPhotosForm" action="/p/add/photos/{{$post->id}}/upload" method="POST" class="dropzone">{{csrf_field()}}</form>
	</div>
		<div class="col-md-4">
			<h3>Choose a primary photo</h3>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas suscipit justo odio, ac finibus ante volutpat sed. Cras cursus diam et tortor blandit dignissim. Fusce fringilla nibh ut metus ultrices vulputate. Vivamus luctus facilisis lorem in volutpat. Etiam dapibus ultrices mi, ac tincidunt augue ornare in. Fusce aliquam ante non nulla ultricies, id auctor lacus mattis. Mauris risus metus, aliquam in sodales ac, lacinia at leo. Etiam bibendum sagittis vestibulum. Vestibulum at consequat neque. Sed sit amet congue est, ac tristique dolor. Fusce at dignissim tellus.</p>
		</div>
	</div>
	<form action="{{url('p/add/photos/'.$post->id.'/primary')}}" method="POST">
		<input type="hidden" id="primary_photo_id" name="primary_photo_id" value="" />
		{{csrf_field()}}
		<button type="submit" class="btn btn-primary">Add info</button>
	</form>
</div>
@stop
@push('scripts.footer')
<script src="/js/dropzone.js"></script>
<script>
	Dropzone.options.addPhotosForm = {
		paramName: 'photo',
		maxFileSize: 3.3,
		acceptedFiles: '.jpeg, .jpg, .png, .bmp',
		init: function() {
			this.on("queuecomplete", function(file) { if(this.success()){location.reload();} });
		},
	}
    $('#delete-selected-photo').on('click', function(e){
        var selectedPhoto = $('.photos-controller a').find('.selected').parent().attr('data-id');
        if(confirm('sure want to delete the selected image?')){
            $(this).attr('href', '/p/delete/photos/' + {{$post->id}} + '/' + selectedPhoto);
        }else{
            return false;
        }
    });
    $('#primary-selected-photo').on('click', function(e){
        var selectedPhoto = $('.photos-controller a').find('.selected').parent().attr('data-id');
        if(selectedPhoto){
            $('input#primary_photo_id').val(selectedPhoto);
        }
    });
</script>
@endpush
