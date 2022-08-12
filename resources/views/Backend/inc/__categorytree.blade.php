@foreach($children as $subcategory)
    <ul style="list-style-type: none">
        @if(count($subcategory->children))

            <li>
                {{$subcategory->title}} |
                <a href="{{route("Category.edit",["id"=>$subcategory->id])}}"> <i class="fas fa-pen fa-xs"></i></a> | <i onclick="categoridelete({{$subcategory->id}})" class="fas fa-trash fa-xs"></i>
                @include('Backend.inc.__categorytree',['children'=>$subcategory->children])

            </li>
        @else
            <li>{{$subcategory->title}} |<a href="{{route("Category.edit",["id"=>$subcategory->id])}}"> <i class="fas fa-pen fa-xs"></i></a> | <i onclick="categoridelete({{$subcategory->id}})" class="fas fa-trash fa-xs"></i></li>
        @endif


    </ul>
@endforeach
