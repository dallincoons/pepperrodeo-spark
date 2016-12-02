@extends('layouts.app')

@section('content')
<show-all-recipes inline-template class="content-wrapper">
<div>
        <h2 class="page-title">My Recipes</h2>

        <form method="POST" action="/recipe/deleteMultiple" id="deleteForm">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <nav class="mini-nav">
             <ul class="mini-nav-options">
                 <li><a href="/recipe/create"><i class="fa fa-plus"></i></a></li>
                 <li><a v-on:click="toggleShowCheckBoxes(true)"><i class="fa fa-trash"></i></a></li>
             </ul>
        </nav>
        <div class="category-wrapper">
            <ul>
                @foreach($recipesWithCategories as $category => $recipes)
                <li class="category-title"><h3>{{$category}}</h3></li>
                <li>
                    <ul class="recipes">
                        @foreach($recipes as $recipe)
                            <li class="recipe">
                                <label class="control control--checkbox"><a href="/recipe/{{$recipe->id}}">{{$recipe->title}}</a>
                                    <input type="checkbox" v-model="recipes" id="cbox1" name="recipeIds[]" class="recipe-check" value="{{$recipe}}">
                                    <div v-if="showCheckBoxes" class="control__indicator"></div>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </li>
                @endforeach
            </ul>
        </div>

            <input v-if="showCheckBoxes" v-on:click="deleteRecipes()" type="button" value="Delete" class="pr-btn recipe-list-delete-btn">
        </form>
</div>
</show-all-recipes>
@endsection
