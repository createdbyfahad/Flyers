<div class="panel panel-default col-md-2 user-cp-menu">
    <div class="list-group">
        <a href="{{route('myOffers')}}" class="list-group-item @if($current == 'my_offers')active @endif">{{trans("word.my_offers")}}</a>
        <a href="#" class="list-group-item">{{trans("word.user_preferences")}}</a>
        <a href="#" class="list-group-item">{{trans("word.user_preferences")}}</a>
        <a href="#" class="list-group-item"><span class="badge">14</span> {{trans("word.user_preferences")}}</a>
        <a href="{{route('userPreferences')}}" class="list-group-item @if($current == 'preferences')active @endif">{{trans("word.user_preferences")}}</a>
    </div>
</div>