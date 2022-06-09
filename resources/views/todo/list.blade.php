@extends('layouts.app')
@php
    use App\Models\Todo;
@endphp
@pushonce('styles')
    <link rel="stylesheet" href="{{asset('css/todo_item.css')}}"/>
@endPushonce

@section('body')
    @foreach(Todo::all() as $todoRow)
        <x-todo.item title="{{$todoRow->title}}" status="{{$todoRow->status}}" description="{{$todoRow->description}}" due="{{$todoRow->due}}"/>
    @endforeach
@endsection