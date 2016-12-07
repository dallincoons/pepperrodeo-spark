@extends('layouts.app')

@section('content')
<show-departments inline-template><div>
    <ul>
        <li v-for="department in departments">@{{department.name}}<span v-on:click="removeDepartment(department.id)">X</span></li>
    </ul>

    <button v-on:click="addDepartment()">+ Add Department</button>
</div></show-departments>
@endsection
