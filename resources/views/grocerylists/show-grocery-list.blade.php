@extends('layouts.app')

@section('content')
<show-list inline-template v-cloak>
<div class="create-list-wrapper">
    <div class="create-list" v-if="!showRecipes">
        <div class="list-header-section">
            <h2 class="page-title">{{$grocerylist->title}} <a href="#" class="darker-remove"><i v-on:click.prevent="toggleEdit()" class="fa fa-pencil"></i></a></h2>
            <div class="centering-buttons">
                <a  v-bind:class="{ 'toggle-active': groupByValue == 'department_name', 'toggle-inactive': groupByValue != 'department_name' }"  v-on:click="setGroupBy('department_name')" class="toggle">By Dept.</a>
                <a v-bind:class="{ 'toggle-active': groupByValue == 'recipe_title', 'toggle-inactive': groupByValue != 'recipe_title' }" v-on:click="setGroupBy('recipe_title')" class="toggle">By Recipe</a>
            </div>

            <nav class="mini-nav">
                <ul class="mini-nav-options">
                    <li><a v-on:click="showRecipes = true"><i class="fa fa-cutlery"></i></a></li>
                    <li><a v-on:click="setAddAnItem(true)"><i class="fa fa-plus"></i></a></li>
                    <li><a onClick="window.print()"><i class="fa fa-print"></i></a></li>
                </ul>
            </nav>

            <list-desktop-nav></list-desktop-nav>

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
                    <label class="control control--checkbox"><a class="add-recipe-list">@{{recipe.title}}</a>
                        <input type="checkbox" :value="recipe.id" v-model="recipesToAdd" />
                        <div class="control__indicator"></div>
                    </label>
                <li>
            </ul>

            <div class="add-recipe-buttons">
                <button v-on:click="showRecipes = false" class="  save-button"><i class="fa fa-chevron-circle-left"></i> Back</button>
                <button v-on:click="addRecipes(recipesToAdd)" class="  save-button"> Add <i class="fa fa-plus-circle"></i></button>
            </div>
        </div>
    </div>

</div>
</show-list>
@endsection
