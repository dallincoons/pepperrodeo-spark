@extends('layouts.app')

@section('content')
<create-list inline-template v-cloak>
<div class="create-list-wrapper">
    <div class="create-list" v-if="!showRecipes">
        <h2 class="page-title">Create List</h2>
        <list-item-group-by-menu></list-item-group-by-menu>

        {{Form::open(['url' => '/grocerylist', 'id' => 'list-form', 'data-parsley-validate' => ''])}}

        <div v-show="editing">
            <div class="title-section">
                <label for="title" class="form-heading">Title*</label>
                <input type="text" placeholder="September Grocery List" v-model="title" id="title" name="title" required data-parsley-errors-messages-disabled>
            </div>

            <a v-on:click="showRecipes = true" class="create-list-option"><i class="fa fa-plus-circle"></i> Add a recipe</a>
            <a v-on:click="addAnItem = true" class="create-list-option"><i class="fa fa-plus-circle"></i> Add an item</a>

            <add-item-form v-if="addAnItem" v-on:hide="addAnItem = false" v-on:add="addItem"></add-item-form>
        </div>

        <grouped-grocery-lists :items="items" v-on:save-edit="saveItemEdit" v-on:delete="removeItemFromList"></grouped-grocery-lists>

        <div class="centering-buttons" v-show="editing">
            <button type="button" v-on:click="submitListForm()" class="save-button  " v-show="items.length">Save List</button>
        </div>

        @if (count($errors) > 0)
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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
                <button v-on:click="showRecipes = false" class="save-button"><i class="fa fa-chevron-circle-left"></i> Back</button>
                <button v-on:click="addRecipes(recipesToAdd)" class="save-button"> Add <i class="fa fa-plus-circle"></i></button>
            </div>

        </div>
    </div>
</div>
</create-list>
@endsection
