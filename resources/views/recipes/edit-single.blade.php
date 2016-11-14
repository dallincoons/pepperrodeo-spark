@extends('layouts.app')

@section('content')
    {!! Form::model($recipe, ['method' => 'POST', 'route' => ['recipe.update', $recipe->getKey()]]) !!}
        {!! method_field('patch') !!}
            @include('recipes.includes.recipe-form')
        {!! Form::submit() !!}
    {!! Form::close() !!}
@endsection
