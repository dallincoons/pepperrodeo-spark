@extends('layouts.app', ['vue' => 'single-list'])

@section('content')
<single-list inline-template>
<div>
    <div class="grocery-list-wrapper">

        <h2 class="page-title">{{$grocerylist->title}}</h2>

        <nav class="mini-nav">
            <ul class="list-nav">
                <li><a href="/grocerylist/{{$grocerylist->id}}/edit"><i class="fa fa-pencil"></i></a></li>
                <li><form action="/grocerylist/{{$grocerylist->id}}" method="POST" id="list-delete">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <a v-on:click="submitDeleteList()"><i class="fa fa-trash"></i></a>
                </form></li>
            </ul>
        </nav>

        <div class="list-view-toggle">
            <a href="/grocerylist/{{$grocerylist->getKey()}}?sortBy=item" class="toggle-active">By Items</a>
            <a href="/grocerylist/{{$grocerylist->getKey()}}?sortBy=recipe" class="toggle-inactive">By Recipe</a>
        </div>

        @foreach($grocerylist->items as $category => $list_items)
            <div class="category-wrapper">
                <ul class="category">
                    <li class="category-title"><h3>{{$category ?: 'N/A'}}</h3></li>
                    <li>
                        <ul class="recipes list-items">
                            @foreach($list_items as $item)
                                <li>{{$item->quantity}} {{$item->type}} {{$item->name}}</li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>
        @endforeach
    </div>
</div>
</single-list>
@endsection
