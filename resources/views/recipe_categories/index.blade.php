@extends('layouts.app')

@section('content')
<all-recipe-categories inline-template><div class="category-wrapper">
        <h2 class="page-title">My Categories</h2>
    <ul class="category create-list-wrapper">
        <li class="list-item" v-for="category in recipe_categories">
            <div class="list-item-wrapper"> @{{category.name}}</div>
            <div class="remove-item">
                <span v-on:click="removeCategory(category.id)"><i class="fa fa-times-circle-o"></i></span>
            </div>
        </li>
    </ul>

        <div class="centering-buttons">
            <button v-on:click="addCategory()" class="pr-button save-button"><i class="fa fa-plus-circle"></i> Add Category</button>
        </div>
</div></all-recipe-categories>
@endsection
