@extends('layouts.app', ['vue' => 'single-list'])

@section('content')
<single-list inline-template v-cloak>
<div class="grocery-list-wrapper">

        <h2 class="page-title">{{$grocerylist->title}} <a href="/grocerylist/{{$grocerylist->id}}/edit" class="list-edit-large"><i class="fa fa-pencil"></i></a></h2>

        <nav class="mini-nav">
            <ul class="mini-nav-options">
                <li><a href="/grocerylist/{{$grocerylist->getKey()}}/edit"><i class="fa fa-pencil"></i></a></li>
                <li><form action="/grocerylist/{{$grocerylist->getKey()}}" method="POST" id="list-delete" class="mini-delete">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <a v-on:click="submitDeleteList()"><i class="fa fa-trash"></i></a>
                </form></li>
            </ul>
        </nav>

        <div class="centering-buttons">
            <a href="/grocerylist/{{$grocerylist->getKey()}}?sortBy=item" class="toggle toggle-active">By Dept.</a>
            <a href="/grocerylist/{{$grocerylist->getKey()}}?sortBy=recipe" class="toggle toggle-inactive">By Recipe</a>
        </div>

        @foreach($grocerylist->items as $category => $list_items)
            <div class="category-wrapper">
                <ul class="category">
                    <li class="category-title"><h3>{{$category ?: 'N/A'}}</h3></li>
                    <li>
                        <ul class="list-items">
                            @foreach($list_items as $item)
                                <li class="list-item"><div class="print-checkbox"></div>{{$item->quantity}} {{$item->type}} {{$item->name}}<button v-on:click="showEditModal({{$item}})">Edit</button></li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>
        @endforeach

    <input type="button" class="print-btn"
           onClick="window.print()"
           value="Print List"/>
</div>
</single-list>
@endsection
