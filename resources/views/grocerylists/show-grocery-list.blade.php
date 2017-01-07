@extends('layouts.app')

@section('content')
<show-list inline-template v-cloak>
<div class="create-list-wrapper">
    <div class="create-list" v-if="!showRecipes">
            <h2 class="page-title">{{$grocerylist->title}} <a href="#" class="darker-remove"><i v-on:click.prevent="toggleEdit()" class="fa fa-pencil"></i></a></h2>
            <div class="centering-buttons">
                <a  v-bind:class="{ 'toggle-active': groupByValue == 'department', 'toggle-inactive': groupByValue != 'department' }"  v-on:click="setGroupBy('department')" class="toggle">By Dept.</a>
                <a v-bind:class="{ 'toggle-active': groupByValue == 'recipe_title', 'toggle-inactive': groupByValue != 'recipe_title' }" v-on:click="setGroupBy('recipe_title')" class="toggle">By Recipe</a>
            </div>

            <div class="centering-buttons">
                <a v-on:click="setShowRecipes(true)" class="create-list-option"><i class="fa fa-plus-circle"></i> Add a recipe</a>
                <a v-on:click="setAddAnItem(true)" class="create-list-option"><i class="fa fa-plus-circle"></i> Add an item</a>
                <a class="create-list-option" onClick="window.print()"><i class="fa fa-print"></i> Printer Friendly</a>
            </div>


        {!! Form::model($grocerylist, ['method' => 'POST', 'route' => ['grocerylist.update', $grocerylist->id], 'id' => 'list-form']) !!}
            {!! method_field('patch') !!}
            @include('grocerylists.includes.list-form')
        {{Form::close()}}
    </div>
    <div v-if="showRecipes" class="choose-recipe">
        <h3 class="page-title">My Recipes</h3>

        <div class="category-wrapper">
            <ul class="category recipes">
                <li v-for="recipe in unaddedRecipes" class="add-recipe-options">
                    <label class="control control--checkbox"><a>@{{recipe.title}}</a>
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
</show-list>
@endsection
