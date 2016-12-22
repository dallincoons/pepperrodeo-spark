@extends('layouts.app')

@section('content')
<show-departments inline-template><div class="category-wrapper">

    <h2 class="page-title">My Departments</h2>
    <ul class="category create-list-wrapper">
        <li class="list-item" v-for="department in departments">
            <div class="list-item-wrapper"> @{{department.name}}</div>
            <div class="remove-item">
                <span v-on:click="removeDepartment(department.id)" class="darker-remove"><i class="fa fa-times-circle-o"></i></span>
            </div>

        </li>
    </ul>
    <div class="centering-buttons">
        <button v-on:click="addDepartment()" class="pr-button save-button"><i class="fa fa-plus-circle"></i> Add Department</button>
    </div>

</div></show-departments>
@endsection
