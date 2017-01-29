@extends('layouts.app')

@section('content')
<create-list inline-template v-cloak>
<div class="create-list-wrapper">
    <div class="create-list" v-if="!showRecipes">
        <h2 class="page-title">Create List</h2>
        <div class="centering-buttons">
            <a  v-bind:class="{ 'toggle-active': groupByValue == 'department', 'toggle-inactive': groupByValue != 'department' }"  v-on:click="groupByValue = 'department_name'" class="toggle">By Dept.</a>
            <a v-bind:class="{ 'toggle-active': groupByValue == 'recipe_title', 'toggle-inactive': groupByValue != 'recipe_title' }" v-on:click="groupByValue = 'recipe_title'" class="toggle">By Recipe</a>
        </div>

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

        <div class="category-wrapper">
            <ul class="category" v-for="(items, groupName) in itemsGrouped">
                <li class="category-title"><h3>@{{ groupName }}</h3> <span v-on:click="deleteGroup(items)" class="remove-dept"><i class="fa fa-times-circle-o"></i></span></li>
                <ul class="recipes list-items">
                    <li v-for="item in items" class="list-item">
                        <div v-if="!item.editing" class="list-item-editing">
                            <div class="list-item-wrapper">
                                <span class="list-item-added">@{{ item.quantity }}</span>
                                <span class="list-item-added">@{{ item.type }}</span>
                                <span class="list-item-added">@{{ item.name }} </span>
                            </div>
                            <div class="options-dropdown-wrapper">
                                <a class="dropdown-indicator" v-on:click="toggleListOptions(item)" ><i data-type="toggle-list-option" class="fa fa-ellipsis-h"></i></a>
                                <ul class="options-dropdown" v-show="item.toggleOptions">
                                    <li v-on:click="toggleItemEditing(item)"><i class="fa fa-pencil"></i><a> Edit Item</a></li>
                                    <li v-on:click="removeItemFromList(item)"><i class="fa fa-trash-o"></i><a> Delete Item</a></li>
                                </ul>
                            </div>

                        </div>
                        <div v-else class="edit-info-wrapper">
                            <div class="edit-inputs">
                                <input class="list-item-added ingredient-info" v-model="item.quantity" :value="item.quantity" type="number"/>
                                <input class="list-item-added ingredient-info" v-model="item.type" :value="item.type" />
                                <input class="list-item-added ingredient-info" v-model="item.name" :value="item.name" />
                                <select name="category" v-model="item.department.id" class="ingredient-info dept-edit-info">
                                    <option v-for="department in departments" :value="department.id">@{{department.name}}</option>
                                </select>
                                <a class="edit-button" v-on:click="saveItemEdit(item)"><i class="fa fa-check-circle-o"></i></a>
                            </div>

                            <div class="editing-button-wrapper">
                                <a class="edit-button" v-on:click="toggleItemEditing(item)"><i class="fa fa-times-circle-o"></i></a>
                            </div>

                        </div>
                    </li>
                </ul>
            </ul>
        </div>

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
