@extends('layouts.app')

@section('content')
    <h2><a href="/recipe">All Recipes</a></h2>
    <div class="category-wrapper">
        <ul class="category">
            <li class="category-title"><h3>{{$category->name}}</h3></li>
            <li>
                <ul class="recipes">
                    @foreach($category->recipes as $recipe)
                        <li>
                            <label class="control control--checkbox"><a href="/recipe/{{$recipe->id}}">{{$recipe->title}}</a></label>
                        </li>
                    @endforeach
                </ul>
            </li>
        </ul>
    </div>
@endsection
