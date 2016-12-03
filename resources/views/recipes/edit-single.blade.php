@extends('layouts.app')

@section('content')
    <edit-single-recipe inline-template v-cloak>
    <div>
    {!! Form::model($recipe, ['method' => 'POST', 'route' => ['recipe.update', $recipe->getKey()]]) !!}
        {!! method_field('patch') !!}
            @include('recipes.includes.recipe-form')
        {!! Form::submit() !!}
    {!! Form::close() !!}
    </div>
    </edit-single-recipe>
@endsection
