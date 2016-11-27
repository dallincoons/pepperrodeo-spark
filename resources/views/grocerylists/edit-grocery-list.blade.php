@extends('layouts.app', ['vue' => 'edit-grocery-list'])

@section('content')
<list-form inline-template>
<div>
    <div class="create-list" v-if="!showRecipes">
        <h2 class="page-title">Edit List</h2>
        <div class="centering-buttons">
            <a  v-bind:class="{ 'toggle-active': groupByValue == 'category', 'toggle-inactive': groupByValue != 'category' }"  v-on:click="setGroupBy('category')">By Items</a>
            <a v-bind:class="{ 'toggle-active': groupByValue == 'recipe_title', 'toggle-inactive': groupByValue != 'recipe_title' }" v-on:click="setGroupBy('recipe_title')">By Recipe</a>
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
                        <input type="checkbox" :value="recipe.id" v-model="recipesToAdd" class="recipe-check"/>
                        <div class="control__indicator"></div>
                    </label>
                <li>
            </ul>

            <div class="add-recipe-buttons">
                <button v-on:click="setShowRecipes(false)" class="pr-button save-button"><i class="fa fa-chevron-circle-left"></i> Back</button>
                <button v-on:click="addRecipes(recipesToAdd)" class="pr-button save-button"> Add <i class="fa fa-plus-circle"></i></button>
            </div>
        </div>
    </div>
</div>
</list-form>
@endsection
