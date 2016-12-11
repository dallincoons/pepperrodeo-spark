@extends('layouts.app')

@section('content')
<all-recipe-categories inline-template><div>
    <ul>
        <li v-for="category in recipe_categories">@{{category.name}}<span v-on:click="removeCategory(category.id)">X</span></li>
    </ul>

    <button v-on:click="addCategory()">+ Add Department</button>
</div></all-recipe-categories>
@endsection
