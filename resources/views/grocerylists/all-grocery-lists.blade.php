@extends('layouts.app', ['vue' => 'all-grocery-lists'])

@section('content')
<all-grocery-lists inline-template>
<div class="content-wrapper">

    <form method="POST" action="/grocerylist/deleteMultiple" id="deleteForm">

        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <h2 class="page-title">My Lists</h2>
        <nav class="mini-nav">
            <ul class="mini-nav-options">
                <li><a href="/grocerylist/create"><i class="fa fa-plus"></i></a></li>
                <li><a v-on:click="toggleShowCheckBoxes()"><i class="fa fa-trash"></i></a></li>
            </ul>
        </nav>

        <ul class="lists-wrapper">
            @foreach($grocerylists as $list)
                <li class="list">
                    <label class="control control--checkbox"><i class="fa fa-list list-info"></i> <a href="grocerylist/{{$list->id}}" class="list-info">{{$list->title}}</a>
                        <input type="checkbox" v-model="lists" id="cbox1" name="lists[]" class="recipe-check" value="{{$list}}">
                        <div v-if="showCheckBoxes" class="control__indicator"></div>
                    </label>
                </li>
                <li></li>
            @endforeach
        </ul>

        <input v-if="showCheckBoxes" v-on:click="deleteLists()" type="button" value="Delete">
    </form>

</div>
</all-grocery-lists>
@endsection
