@extends('layouts.app')

@section('content')
    <edit-single-recipe inline-template v-cloak>
    <div class="edit-wrapper">
        <div class="recipe-wrapper">
            {!! Form::model($recipe, ['method' => 'POST', 'route' => ['recipe.update', $recipe->getKey()]]) !!}
            {!! method_field('patch') !!}
            @include('recipes.includes.recipe-form')
            {!! Form::submit('Submit', ['class' => 'save-button']) !!}
            {!! Form::close() !!}
        </div>
    </div>

    </edit-single-recipe>
@endsection
