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

            <all-recipes-list :grouped-recipes="recipesByCategory" :recipes="recipes"></all-recipes-list>

        </form>
</div>
</show-all-recipes>
@endsection
