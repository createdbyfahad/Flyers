@if($progress_bar == 3)
<div class="col-md-12 noPadding">
    <div class="col-md-9 noPadding">
    <div class="panel"><div class="panel-body"></div> </div>
    </div>
    <div class="col-md-3">
    @if($post->status == 0)
        <a class="post-activate-btn btn-lg btn" href="{{route('activatePost', $post->id)}}">Publish the post</a>
    @else
        <a class="post-disable-btn btn-lg btn" href="{{route('disablePost', $post->id)}}">Disable the post</a>
    @endif
    </div>
</div>
@endif