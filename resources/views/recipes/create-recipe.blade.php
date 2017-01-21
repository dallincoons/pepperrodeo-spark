@extends('layouts.app')

@section('content')
    <create-recipe inline-template v-cloak>
    <div class="add-recipe-content">
        <h3 class="page-title">New Recipe</h3>
        <div class="recipe-form">
            {!! Form::open(array('url' => '/recipe', 'data-parsley-validate' => '')) !!}

                @include('recipes.includes.recipe-form')

            {{ Form::close() }}

        </div>
    </div>
    </create-recipe>
@endsection
