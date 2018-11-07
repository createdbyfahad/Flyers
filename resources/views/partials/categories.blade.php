@foreach($categories as $category)
	@if($category->children->count() > 0)
	<div class="col-md-2 category">
		<div class="category-title"><h4><a href="/search?c={{$category->code}}">{{$category->name}}</a></h4></div>
		<ul class="category-list">
		@foreach($category->children as $subitem)
			<li><a href="/search?c={{$subitem->code}}">{{$subitem->name}}</a></li>
		@endforeach
		</ul>
	</div>
	@elseif($category->parent == '')
	<div class="col-md-2">
	<div class="panel panel-default">
		<div class="panel-heading"><a href="/search?c={{$category->code}}"><h3 class="panel-title">{{$category->name}}</h3></h3></div>
	</div>
	</div>
	@endif
@endforeach