@extends('layouts.app')

@section('content')
<all-grocery-lists inline-template v-cloak>
<div class="content-wrapper">

    <form method="POST" action="/grocerylist/deleteMultiple" id="deleteForm">

        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <h2 class="page-title">My Lists</h2>
        <div class="centering-buttons">
            <a href="/grocerylist/create" class="create-list-option hide-options"><i class="fa fa-plus"></i> Create List</a>
            <a v-on:click="deleteLists()" class="create-list-option hide-options"><i class="fa fa-trash"></i> Delete Lists</a>
        </div>


        <nav class="mini-nav">
            <ul class="mini-nav-options">
                <li><a href="/grocerylist/create"><i class="fa fa-plus"></i></a></li>
                <li><a v-on:click="deleteLists()"><i class="fa fa-trash"></i></a></li>
            </ul>
        </nav>

        @if(count($grocerylists))
        <ul class="lists-wrapper">
            @foreach($grocerylists as $list)
                <li class="list">
                    <label class="control control--checkbox"><i class="fa fa-list list-info"></i> <a href="/grocerylist/{{$list->id}}" class="list-info">{{$list->title}}</a>
                        <input type="checkbox" v-model="lists" id="cbox1" name="lists[]"  value="{{$list}}">
                        <div class="control__indicator"></div>
                    </label>
                </li>
                <li></li>
            @endforeach
        </ul>

        @else
        <div class="lists-wrapper no-content">
            <h4>Looks like you don't have any lists yet!</h4>
            <a href="/grocerylist/create" class="pr-button save-button"><i class="fa fa-plus-circle"></i> Create a List</a>
        </div>


        @endif
        
    </form>

</div>
</all-grocery-lists>
@endsection
