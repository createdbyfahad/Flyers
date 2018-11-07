<ol class="progress-track col-md-12">
    <li class="@if($progress_bar == 1) progress-current @endif progress-done">
        <center>
            <div class="icon-wrap">
                <svg class="icon-state icon-check-mark">
                    <use xlink:href="#icon-check-mark"></use>
                </svg>

                <svg class="icon-state icon-down-arrow">
                    <use xlink:href="#icon-down-arrow"></use>
                </svg>
            </div>
            <span class="progress-text">Add Photo</span>
        </center>
    </li>

    <li class="@if($progress_bar < 2) progress-todo @elseif($progress_bar == 2) progress-current @endif progress-done">
        <center>
            <div class="icon-wrap">
                @if($progress_bar == 3)
                    <a href="/p/add/photos/{{$post->id}}">
                @endif
                <svg class="icon-state icon-check-mark">
                    <use xlink:href="#icon-check-mark"></use>
                </svg>
                @if($progress_bar == 3)
                    </a>
                @endif
                <svg class="icon-state icon-down-arrow">
                    <use xlink:href="#icon-down-arrow"></use>
                </svg>
            </div>
            <span class="progress-text">Fill Details</span>
        </center>
    </li>

    <li class="@if($progress_bar < 3) progress-todo @elseif($progress_bar == 3) progress-current @endif progress-done">
        <center>
            <div class="icon-wrap">
                <svg class="icon-state icon-check-mark">
                    <use xlink:href="#icon-check-mark"></use>
                </svg>

                <svg class="icon-state icon-down-arrow">
                    <use xlink:href="#icon-down-arrow"></use>
                </svg>
            </div>
            <span class="progress-text">Publish</span>
        </center>
    </li>
</ol>