@extends('layouts.app-todo')

@php
use App\Models\Todo;
@endphp

@section('body')
    @php
    $fakeTodo = new Todo();
    $fakeTodo->id = -1;
    $fakeTodo->title = 'title';
    $fakeTodo->status = 'waiting';
    $fakeTodo->description = 'description';
    $fakeTodo->due = '2020-12-20 12:23:00';
    @endphp
    <x-todo.item :todo="$fakeTodo" style="display:none" />

    @forelse($todos as $todo)
        <x-todo.item :todo="$todo" />
    @empty
        <x-todo.empty />
    @endforelse
@endsection
