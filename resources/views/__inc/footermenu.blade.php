@php
    $catList=\App\Http\Controllers\HomeController::CatList();
@endphp
@foreach($catList as $rs)
    <li><a href="{{route('categoryproducts',['id'=>$rs->id,'slug'=>$rs->seo_url])}}">{{$rs->title}}</a>
        @if(count($rs->children))
            @include('__inc.__categorytree',['children'=>$rs->children])
        @endif
    </li>

@endforeach