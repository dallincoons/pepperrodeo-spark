@extends('layouts.app')

@section('content')
<single-recipe inline-template>
<div>
    <a v-on:click="toggleShowListSelection()">Add to Grocery List</a>
    <select class="lists" v-show="showListSelection" v-model="selectedList">
            <option v-for="list in grocerylists" :value="list.id"> @{{ list.title }}</option>
    </select>
    <button type="button" v-show="showListSelection" v-on:click="addToGroceryList()">Submit</button>
    <div class="recipe-wrapper">
        <h2 class="page-title">{{$recipe->title}}</h2>
        <h6 class="recipe-cat">Category: <a href="/recipecategory/{{$recipe->category->getKey()}}">{{$recipe->category->name}}</a></h6>
        <nav class="mini-nav">
            <ul>
                <li><a href="/recipe/create"><i class="fa fa-cart-plus"></i></a></li>
                <li><a href="{{$recipe->getKey()}}/edit"><i class="fa fa-pencil"></i></a></li>
                <li><form action="/recipe/{{$recipe->id}}" method="POST" id="recipe-delete">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <a v-on:click="submitDeleteRecipe()"><i class="fa fa-trash"></i></a>
                </form></li>
            </ul>
        </nav>

        <h3 class="form-heading">Ingredients</h3>
        <ul class="ingredients">
            @foreach($recipe->items as $item)
                <li>{{$item->quantity}} {{$item->type}} {{$item->name}}</li>
            @endforeach
        </ul>

        <h3 class="form-heading">Directions</h3>
        <p>{{$recipe->directions}}</p>
    </div>
</div>
</single-recipe>

@endsection
