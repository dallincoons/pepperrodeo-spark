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

            <div class="centering-buttons">
                <a v-on:click="setShowRecipes(true)" class="create-list-option"><i class="fa fa-plus-circle"></i> Add a recipe</a>
                <a v-on:click="setAddAnItem(true)" class="create-list-option"><i class="fa fa-plus-circle"></i> Add an item</a>
                <a class="create-list-option" onClick="window.print()"><i class="fa fa-print"></i> Printer Friendly</a>
            </div>

            <nav class="mini-nav">
                <ul class="mini-nav-options">
                    <li><a v-on:click="setShowRecipes(true)"><i class="fa fa-cutlery"></i></a></li>
                    <li><a v-on:click="setAddAnItem(true)"><i class="fa fa-plus"></i></a></li>
                    <li><a onClick="window.print()"><i class="fa fa-print"></i></a></li>
                </ul>
            </nav>


            <div class="item-section" v-if="addAnItem">
                <div class="items-inputs">
                    <div class="ingredient-input">
                        <label for="quantity" class="sub-heading">Qty</label>
                        <input type="text" id="quantity" v-model="newItemQty" name="'recipeFields[' + index + '][quantity]'" class="ingredient-info" placeholder="1" @keyup.enter="addItem(recipeFields)"/>
                    </div>

                    <div class="ingredient-input">
                        <label for="type" class="sub-heading">Type</label>
                        <input type="text" id="type" v-model="newItemType" name="'recipeFields[' + index + '][type]'" class="ingredient-info" placeholder="bottle" @keyup.enter="addItem(recipeFields)">
                    </div>

                    <div class="ingredient-input">
                        <label for="item" class="sub-heading">Item</label>
                        <input type="text" id="item" v-model="newItemName" name="'recipeFields[' + index + '][name]'" class="ingredient-info" placeholder="shampoo" @keyup.enter="addItem(recipeFields)"/>
                    </div>

                    <div class="ingredient-input">
                        <label for="category" class="sub-heading dept-label">Department</label>
                        <select name="category" v-model="newDepartmentId">
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{$department->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="add-wrapper ingredient-input">
                        <button type="button" v-on:click="addItem(recipeFields)" class="add-button"><i class="fa fa-plus-circle"></i></button>
                        <button type="button" v-on:click="addAnItem = false" class="add-button"><i class="fa fa-times-circle-o"></i></button>
                    </div>
                </div>
            </div>
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
                <button v-on:click="setShowRecipes(false)" class="  save-button"><i class="fa fa-chevron-circle-left"></i> Back</button>
                <button v-on:click="addRecipes(recipesToAdd)" class="  save-button"> Add <i class="fa fa-plus-circle"></i></button>
            </div>
        </div>
    </div>

</div>
</show-list>
@endsection
