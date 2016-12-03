@extends('layouts.app')

@section('content')
<single-recipe inline-template v-cloak>
<div class="recipe-wrapper">
    <h2 class="page-title">{{$recipe->title}}</h2>
    <h6 class="recipe-cat">Category: <a href="/recipecategory/{{$recipe->category->getKey()}}">{{$recipe->category->name}}</a></h6>
    <nav class="mini-nav">
        <ul class="mini-nav-options">
            <li><a v-on:click="toggleShowListSelection()"><i class="fa fa-cart-plus"></i></a></li>
            <li><a href="{{$recipe->getKey()}}/edit"><i class="fa fa-pencil"></i></a></li>
            <li><form action="/recipe/{{$recipe->id}}" method="POST" id="recipe-delete">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <a v-on:click="submitDeleteRecipe()"><i class="fa fa-trash"></i></a>
            </form></li>
        </ul>
    </nav>

    <nav class="lg-mini-nav">
        <ul class="lg-mini-nav-options">
            <li><a v-on:click="toggleShowListSelection()"><i class="fa fa-cart-plus"></i> Add to Grocery List</a></li>
            <li><a href="{{$recipe->getKey()}}/edit"><i class="fa fa-pencil"></i> Edit</a></li>
            <li><form action="/recipe/{{$recipe->id}}" method="POST" id="recipe-delete">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <a v-on:click="submitDeleteRecipe()"><i class="fa fa-trash"></i> Delete</a>
                </form>
            </li>
        </ul>

    </nav>

    <ul class="lists" v-show="showListSelection">
        <li class="list" v-for="list in grocerylists" :value="list.id" v-on:click="addToGroceryList(list)"><i class="fa fa-list"></i><a> @{{ list.title }}</a></li>
    </ul>

    <h3 class="form-heading">Ingredients</h3>
    <ul class="recipe-ingredients">
        @foreach($recipe->items as $item)
            <li>{{$item->quantity}} {{$item->type}} {{$item->name}}</li>
        @endforeach
    </ul>

    <h3 class="form-heading">Directions</h3>
    <p class="recipe-directions">{{$recipe->directions}}</p>

</div>
</single-recipe>

@endsection
