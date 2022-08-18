@foreach($children as $subcategory)
    <ul>
        @if(count($subcategory->children))

            <li>
                <a href="{{route('categoryproducts',['slug'=>$subcategory->seo_url,'id'=>$subcategory->id])}}">{{$subcategory->title}}</a>

                @include('__inc.__categorytree',['children'=>$subcategory->children])

            </li>
        @else
            <li> <a href="{{route('categoryproducts',['slug'=>$subcategory->seo_url,'id'=>$subcategory->id])}}">{{$subcategory->title}}</a></li>
        @endif


    </ul>
@endforeach
