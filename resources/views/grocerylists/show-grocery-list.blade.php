@extends('layouts.app')

@section('content')
<show-list inline-template v-cloak>
<div class="create-list-wrapper">
    <div class="create-list" v-if="!showRecipes">
        <div class="list-header-section">
            <h2 class="page-title">{{$grocerylist->title}} <a href="#" class="darker-remove"><i v-on:click.prevent="editing = !editing" class="fa fa-pencil"></i></a></h2>
            <div class="centering-buttons">
                <a  v-bind:class="{ 'toggle-active': groupByValue == 'department_name', 'toggle-inactive': groupByValue != 'department_name' }"  v-on:click="groupByValue = 'department_name'" class="toggle">By Dept.</a>
                <a v-bind:class="{ 'toggle-active': groupByValue == 'recipe_title', 'toggle-inactive': groupByValue != 'recipe_title' }" v-on:click="groupByValue = 'recipe_title'" class="toggle">By Recipe</a>
            </div>

            <nav class="mini-nav">
                <ul class="mini-nav-options">
                    <li><a v-on:click="showRecipes = true"><i class="fa fa-cutlery"></i></a></li>
                    <li><a v-on:click="addAnItem = true"><i class="fa fa-plus"></i></a></li>
                    <li><a onClick="window.print()"><i class="fa fa-print"></i></a></li>
                </ul>
            </nav>

            <list-desktop-nav v-on:show-recipes="showRecipes = true"></list-desktop-nav>

        </div>

        {!! Form::model($grocerylist, ['method' => 'POST', 'route' => ['grocerylist.update', $grocerylist->id], 'id' => 'list-form']) !!}
            {!! method_field('patch') !!}
            <div v-show="editing">
            <div class="title-section">
                <label for="title" class="form-heading">Title*</label>
                <input type="text" placeholder="September Grocery List" v-model="title" id="title" name="title" required data-parsley-errors-messages-disabled>

            </div>

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


        <div class="list-cat-wrapper category-wrapper">
            <ul class="category" v-for="(items, groupName) in itemsGrouped">
                <li class="category-title"><h3>@{{ groupName }}</h3> <span v-on:click="deleteGroup(items)" class="remove-dept"><i class="fa fa-times-circle-o"></i></span></li>
                <ul class="recipes list-items">
                    <li v-for="item in items" class="list-item">
                        <div v-if="!item.editing" class="list-item-editing">
                            <div class="list-item-wrapper">
                                <div class="print-checkbox"></div><span class="list-item-added">@{{ item.quantity }}</span>
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


                            <input type="hidden" :name="'items[' + item.id + '][quantity]'" :value="item.quantity">
                            <input type="hidden" :name="'items[' + item.id + '][name]'" :value="item.name">
                            <input type="hidden" :name="'items[' + item.id + '][type]'" :value="item.type">
                            <input type="hidden" :name="'items[' + item.id + '][department_id]'" :value="item.department.id">
                            <input type="hidden" :name="'items[' + item.id + '][id]'" :value="item.id">
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
                <button v-on:click="showRecipes = false" class="  save-button"><i class="fa fa-chevron-circle-left"></i> Back</button>
                <button v-on:click="addRecipes(recipesToAdd)" class="  save-button"> Add <i class="fa fa-plus-circle"></i></button>
            </div>
        </div>
    </div>

</div>
</show-list>
@endsection
