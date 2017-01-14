@extends('layouts.app')

@section('content')
<show-all-recipes inline-template class="content-wrapper all-recipes-wrapper" v-cloak>
<div>
    <h2 class="page-title">My Recipes</h2>
        <div class="centering-buttons">
            <a class="create-list-option" v-on:click="showListSelection = !showListSelection">
                <i class="fa fa-plus-circle"></i> Add Recipes to List
            </a>
        </div>

        <ul v-show="showListSelection" class="lists">
            <li class="list" v-for="list in grocerylists" :value="list.id" v-on:click="addToGroceryList(list)"><i class="fa fa-list"></i><a> @{{ list.title }}</a></li>
        </ul>

        <form method="POST" action="/recipe/deleteMultiple" id="deleteForm">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <nav class="mini-nav">
             <ul class="mini-nav-options">
                 <li><a href="/recipe/create"><i class="fa fa-plus"></i></a></li>
                 <li v-on:click="showListSelection = !showListSelection"><i class="fa fa-shopping-cart"></i></li>
                 <li><a v-on:click="deleteRecipes()"><i class="fa fa-trash"></i></a></li>
             </ul>
        </nav>
        <div class="category-wrapper">
            <ul v-if="recipes.length" v-for="(recipes, category) in recipesByCategory">
                <li class="category-title"><h3>@{{category}}</h3></li>
                <li>
                    <ul class="recipes">
                            <li v-for="recipe in recipes" class="recipe">
                                <label class="control control--checkbox"><a>@{{recipe.title}}</a>
                                    <input type="checkbox" v-model="selectedRecipes" id="cbox1" name="recipeIds[]"  :value="recipe.id">
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                    </ul>
                </li>
            </ul>

            <div class="lists-wrapper no-content" v-else>
                <h4>Looks like you don't have any recipes yet!</h4>
                <a href="/recipe/create" class="pr-button save-button"><i class="fa fa-plus-circle"></i> Add a Recipe</a>
            </div>
        </div>

        <div class="centering-buttons">
            <input v-show="selectedRecipes.length" v-on:click="deleteRecipes()" type="button" value="Delete" class="pr-btn save-button recipe-list-delete-btn">
        </div>

        </form>
</div>
</show-all-recipes>
@endsection
