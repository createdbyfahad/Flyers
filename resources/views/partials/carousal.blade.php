@foreach($lastPostsCats as $key => $lastPostsCat)
    <div class="lastPostsCat">
        <h2>{!! $lastPostsCat->headTitle !!}
            <div class="pull-left">
                <button class="owl-prev btn btn-default btn-sm" data-action="lastAds{{$key}}"><</button>
                <button class="owl-next btn btn-default btn-sm" data-action="lastAds{{$key}}">></button>
            </div>
        </h2>
        <div class="owl-carousel" id="lastAds{{$key}}">
            @foreach($lastPostsCat as $post)
                <div class="carousalItem item"><a href="{{postURL($post->id, $post->slug)}}" title="{{$post->created_at->diffForHumans()}}">
                    <img src='{{url($post->thumbnail_path)}}' />
                    @if($post->price > 0) <span class='thumbnailPrice'>{{$post->price}} {{trans('word.rs')}}</span> @endif
                    <h5>{{$post->title}}</h5>
                </a></div>
            @endforeach
        </div>
    </div>
@endforeach
@section('scripts.header')<link rel="stylesheet" href="/css/owl.carousel.css">@stop
@push('scripts.footer')
<script src="/js/owl.carousel.min.js"></script>
<script>
  $(document).ready(function() {
    var owl = $(".owl-carousel");
    owl.owlCarousel({
        loop:false,
        margin:10,
        nav:false,
        dots:false,
        rtl: true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:5
            }
    }
  });
  $('.owl-next').click(function(){
    carouselId = $(this).attr('data-action');
    $('#'+carouselId).trigger('next.owl.carousel');
  });
  $('.owl-prev').click(function(){
    carouselId = $(this).attr('data-action');
    $('#'+carouselId).trigger('prev.owl.carousel');
  });
});
</script>
@endpush