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
                    <label class="control control--checkbox"><a :href="recipeUrl(props.item.id)">@{{ props.item.title }}</a>
                        <input type="checkbox" v-model="selectedRecipes" id="cbox1" name="recipeIds[]"  :value="props.item.id">
                        <div class="control__indicator"></div>
                    </label>
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
