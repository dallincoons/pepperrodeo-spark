@extends('layouts.app')

@section('content')
    <edit-single-recipe inline-template v-cloak>
    <div class="edit-wrapper">
        <h3 class="page-title">Edit {{$recipe->title}}</h3>
        <div class="recipe-wrapper">
            {!! Form::model($recipe, ['method' => 'POST', 'route' => ['recipe.update', $recipe->getKey()], 'data-parsley-validate' => '']) !!}
            {!! method_field('patch') !!}
            @include('recipes.includes.recipe-form')
            {!! Form::submit('Submit', ['class' => 'save-button']) !!}
            {!! Form::close() !!}
        </div>
    </div>

    </edit-single-recipe>
@endsection
