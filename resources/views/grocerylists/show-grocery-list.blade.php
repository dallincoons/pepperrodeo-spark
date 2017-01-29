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

            <div class="centering-buttons">
                <a v-on:click="showRecipes = true" class="create-list-option hide-options"><i class="fa fa-plus-circle"></i> Add a recipe</a>
                <a v-on:click="addAnItem = true" class="create-list-option hide-options"><i class="fa fa-plus-circle"></i> Add an item</a>
                <a class="create-list-option hide-options" onClick="window.print()"><i class="fa fa-print"></i> Printer Friendly</a>
            </div>
            <add-item-form v-if="addAnItem" v-on:hide="addAnItem = false" v-on:add="addItem"></add-item-form>

        </div>

        {!! Form::model($grocerylist, ['method' => 'POST', 'route' => ['grocerylist.update', $grocerylist->id], 'id' => 'list-form']) !!}
            {!! method_field('patch') !!}
            <div v-show="editing">
            <div class="title-section">
                <label for="title" class="form-heading">Title*</label>
                <input type="text" placeholder="September Grocery List" v-model="title" id="title" name="title" required data-parsley-errors-messages-disabled>

            </div>

        </div>

        <grouped-list :grouped-items="itemsGrouped">
            <template scope="props">
                <div v-if="!props.item.editing" class="list-item-editing">
                    <div class="list-item-wrapper">
                        <div class="print-checkbox"></div><span class="list-item-added">@{{ props.item.quantity }}</span>
                        <span class="list-item-added">@{{ props.item.type }}</span>
                        <span class="list-item-added">@{{ props.item.name }} </span>
                    </div>
                    <div class="options-dropdown-wrapper">
                        <a class="dropdown-indicator" v-on:click="toggleListOptions(props.item)" ><i data-type="toggle-list-option" class="fa fa-ellipsis-h"></i></a>
                        <ul class="options-dropdown" v-show="props.item.toggleOptions">
                            <li v-on:click="toggleItemEditing(props.item)"><i class="fa fa-pencil"></i><a> Edit Item</a></li>
                            <li v-on:click="removeItemFromList(props.item)"><i class="fa fa-trash-o"></i><a> Delete Item</a></li>
                        </ul>
                    </div>
                </div>
                <div v-else class="edit-info-wrapper">
                    <div class="edit-inputs">
                        <input class="list-item-added ingredient-info" v-model="props.item.quantity" :value="props.item.quantity" type="number"/>
                        <input class="list-item-added ingredient-info" v-model="props.item.type" :value="props.item.type" />
                        <input class="list-item-added ingredient-info" v-model="props.item.name" :value="props.item.name" />
                        <select name="category" v-model="props.item.department.id" class="ingredient-info dept-edit-info">
                            <option v-for="department in departments" :value="department.id">@{{department.name}}</option>
                        </select>
                        <a class="edit-button" v-on:click="saveItemEdit(props.item)"><i class="fa fa-check-circle-o"></i></a>
                    </div>

                    <div class="editing-button-wrapper">
                        <a class="edit-button" v-on:click="toggleItemEditing(props.item)"><i class="fa fa-times-circle-o"></i></a>
                    </div>
                </div>
            </template>
        </grouped-list>

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
