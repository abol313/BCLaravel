@extends('layouts.app-todo')

@section('title', 'Todo Profile')

@section('body')
    @if($todo)
        <x-todo.item :todo="$todo"/>
    @else
        <h1 class="no-todo-item">@lang("todo.no_todo")</h1>
    @endif
@endsection
