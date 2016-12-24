@extends('layouts.app')

@section('content')
<create-list inline-template v-cloak>
<div class="create-list-wrapper">
    <div class="create-list" v-if="!showRecipes">
        <h2 class="page-title">Create List</h2>
        <div class="centering-buttons">
            <a  v-bind:class="{ 'toggle-active': groupByValue == 'category', 'toggle-inactive': groupByValue != 'category' }"  v-on:click="setGroupBy('category')" class="toggle">By Dept.</a>
            <a v-bind:class="{ 'toggle-active': groupByValue == 'recipe_title', 'toggle-inactive': groupByValue != 'recipe_title' }" v-on:click="setGroupBy('recipe_title')" class="toggle">By Recipe</a>
        </div>
        {{Form::open(['url' => '/grocerylist', 'id' => 'list-form', 'data-parsley-validate' => ''])}}
            @include('grocerylists.includes.list-form')

        <ul v-if="list_form_errors">
            <li v-for="error in list_form_errors">@{{ error.reason }}</li>
        </ul>

        {{Form::close()}}
    </div>

    <div v-if="showRecipes" class="choose-recipe">
        <h3 class="page-title">My Recipes</h3>

        <div class="category-wrapper">
            <ul class="category recipes">
                <li v-for="recipe in unaddedRecipes" class="add-recipe-options">
                    <label class="control control--checkbox"><a class="add-recipe-list">@{{recipe.title}}</a>
                        <input type="checkbox" :value="recipe.id" v-model="recipesToAdd" />
                        <div class="control__indicator"></div>
                    </label>
                <li>
            </ul>

            <div class="add-recipe-buttons">
                <button v-on:click="setShowRecipes(false)" class="  save-button"><i class="fa fa-chevron-circle-left"></i> Back</button>
                <button v-on:click="addRecipes(recipesToAdd)" class="  save-button"> Add <i class="fa fa-plus-circle"></i></button>
            </div>

        </div>
    </div>
</div>
</create-list>
@endsection
