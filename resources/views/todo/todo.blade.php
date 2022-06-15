@extends('layouts.app-todo')

@section('title', 'Todo Profile')

@section('body')
    @php
        $redirect = asset("todos/");
        $deletePath = asset("todos/delete/$todo->id"."?redirect=$redirect");
    @endphp
    @if($todo)
        <x-todo.item title="{{ $todo->title }}" status="{{ $todo->status }}"
        description="{{ $todo->description }}" due="{{ $todo->due }}" :delete-path="$deletePath" />
    @else
        <h1 class="no-todo-item">No todo !</h1>
    @endif
@endsection
