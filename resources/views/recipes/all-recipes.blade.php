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

            <all-recipes-list :grouped-recipes="recipesByCategory" :recipes="recipes"></all-recipes-list>

        </form>
</div>
</show-all-recipes>
@endsection
