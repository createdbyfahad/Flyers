<div class="panel panel-default col-md-3 user-cp-menu">
    <div class="panel-heading">
        <h3 class="panel-title">@if($other['in']){{trans("word.in_messages_and_offers")}}@else {{trans("word.out_messages_and_offers")}}@endif</h3>
    </div>
    <div class="list-group panel-body">
        @foreach($offers as $offer)
            <a href="{{route('userInMessagesDialog', $offer->id)}}" class="list-group-item messages-contact-list @if($other['current'] == $offer->id)active-item @endif">
                <div class="message-contact-list-info"><span>@if(isset($offer->amount)){{$offer->amount}} {{trans('word.riyal')}} @else {{trans('word.question')}} @endif</span></div>
                <img class="post-box-owner-pic img-circle" src="{{$offer->offeree->profile_pic}}" />
                <span class="messages-contact-list-name">{{$offer->offeree->profile_name}}</span><br />
                <span class="messages-contact-list-title">{{$offer->post->title}}</span>
            </a>
        @endforeach
    </div>
</div>