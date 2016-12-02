@extends('layouts.app')

@section('content')

    <div class="content-wrapper show-cat-wrapper">

        <div class="category-wrapper">
            <ul class="category">
                <li class="category-title"><h3>{{$category->name}}</h3></li>
                <li>
                    <ul class="recipes">
                        @foreach($category->recipes as $recipe)
                            <li class="recipe">
                                <label class="control control--checkbox"><a href="/recipe/{{$recipe->id}}">{{$recipe->title}}</a></label>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </div>
        <div class="pr-btn"><a href="/recipe"><i class="fa fa-arrow-circle-o-left"></i> All Recipes</a></div>
    </div>

@endsection
