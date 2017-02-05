@extends('layouts.app')

@section('content')
<show-list inline-template v-cloak>
<div class="create-list-wrapper">
    <div class="create-list" v-if="!showRecipes">
        <div class="list-header-section" id="list_header">
            <h2 class="page-title">{{$grocerylist->title}} <a href="#" class="darker-remove"><i v-on:click.prevent="editing = !editing" class="fa fa-pencil"></i></a></h2>

            <list-item-group-by-menu></list-item-group-by-menu>

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

        {!! Form::model($grocerylist, ['method' => 'POST', 'route' => ['grocerylist.update', $grocerylist->id], 'id' => 'list-form', 'class' => 'list-form']) !!}
            {!! method_field('patch') !!}

        <grouped-grocery-lists :items="items" v-on:save-edit="saveItemEdit" v-on:delete="removeItemFromList"></grouped-grocery-lists>

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
</show-list>
@endsection
