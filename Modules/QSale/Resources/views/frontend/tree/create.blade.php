@foreach ($mainCategories as $category)
<ul>
	<li id="{{$category->id}}" data-title="{{$category->translate(locale(), true)->title}}" 
		 data-jstree='{"opened":true  
		{{ ($category->is_end_category == 0 ) ? ',"disabled":true' : ''  }}
		{{ ( in_array($category->id , $selected) ) ? ',"selected":true' : ''  }} }'>
		{{$category->translate(locale(), true)->title}}
		@if($category->children->count() > 0)
			@include('qsale::frontend.tree.create',
                                    ['mainCategories' => $category->children , "selected"=> $selected]
             )
		@endif
	</li>
</ul>
@endforeach
