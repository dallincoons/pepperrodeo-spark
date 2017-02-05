@extends('layouts.app')

@section('content')
<single-recipe inline-template v-cloak>
<div class="recipe-wrapper">
    <h2 class="page-title">{{$recipe->title}}</h2>
    <h6 class="recipe-cat">Category: <a href="/recipe/categories/{{$recipe->category->getKey()}}">{{$recipe->category->name}}</a></h6>
    <nav class="mini-nav">
        <mini-nav-options></mini-nav-options>
    </nav>

    <nav class="lg-mini-nav">
        <mini-nav-options></mini-nav-options>
    </nav>

    <ul class="lists" v-show="showListSelection">
        <li :id="'list' + list.id" class="list" v-for="list in grocerylists" :value="list.id" v-on:click="addToGroceryList(list)"><i class="fa fa-list"></i><a> @{{ list.title }}</a></li>
    </ul>

    <h3 class="form-heading">Ingredients</h3>
    <ul class="recipe-ingredients">
        @foreach($recipe->items as $item)
            <li>{{$item->quantity}} {{$item->type}} {{$item->name}}</li>
        @endforeach
    </ul>

    <h3 class="form-heading">Directions</h3>
    <p class="recipe-directions">{!!  nl2br(e($recipe->directions)) !!}</p>

</div>
</single-recipe>

@endsection
