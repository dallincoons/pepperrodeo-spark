@extends('layouts.app')

@section('content')
<show-all-recipes inline-template class="content-wrapper all-recipes-wrapper" v-cloak>
<div>
    <h2 class="page-title">My Recipes</h2>

        <desktop-nav :grocerylists="grocerylists"></desktop-nav>

        <form method="POST" action="/recipe/deleteMultiple" id="deleteForm">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <recipe-mobile-nav></recipe-mobile-nav>

            <grouped-list :grouped-items="recipesByCategory" v-if="recipes.length">
                <template scope="props">
                            <div>
                                <span><a :href="recipeUrl(props.item.id)">@{{ props.item.title }} </a></span>
                            </div>
                            <div class="options-dropdown-wrapper">
                                <a class="dropdown-indicator" v-on:click="toggleListOptions(props.item)" ><i data-type="toggle-list-option" class="fa fa-ellipsis-h"></i></a>
                                <ul class="options-dropdown" v-show="props.item.toggleOptions">
                                    <li><i class="fa fa-pencil"></i><a :href="recipeEditUrl(props.item.id)"> Edit</a></li>
                                    <li v-on:click="deleteRecipe(props.item)"><i class="fa fa-trash-o"></i><a> Delete</a></li>
                                </ul>
                            </div>
                </template>
            </grouped-list>
            <div class="lists-wrapper no-content" v-else>
                <h4>Looks like you don't have any recipes yet!</h4>
                <a href="/recipe/create" class="pr-button save-button"><i class="fa fa-plus-circle"></i> Add a Recipe</a>
            </div>

            <div class="centering-buttons">
                <input v-show="selectedRecipes.length" v-on:click="deleteRecipes()" type="button" value="Delete" class="pr-btn save-button recipe-list-delete-btn">
            </div>

        </form>
</div>
</show-all-recipes>
@endsection
