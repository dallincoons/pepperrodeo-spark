@extends('layouts.app', ['vue' => 'all-grocery-lists'])

@section('content')
<all-grocery-lists inline-template>
<div>
    <div class="grocery-lists">

    <form method="POST" action="/grocerylist/deleteMultiple" id="deleteForm">

        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <h2 class="page-title">My Lists</h2>
        <nav class="mini-nav">
            <ul>
                <li><a href="/grocerylist/create"><i class="fa fa-plus"></i></a></li>
                <li><a v-on:click="deleteLists()"><i class="fa fa-trash"></i></a></li>
            </ul>
        </nav>

        <ul class="lists">
            @foreach($grocerylists as $list)
                <li class="list">
                    <label class="control control--checkbox"><i class="fa fa-list list-info"></i> <a href="grocerylist/{{$list->id}}" class="list-info">{{$list->title}}</a>
                        <input type="checkbox" id="cbox1" name="listIds[]" class="recipe-check" value="{{$list->id}}">
                        <div class="control__indicator"></div>
                    </label>
                </li>
                <li></li>
            @endforeach
        </ul>
    </form>

    </div>

</div>
</all-grocery-lists>
@endsection
