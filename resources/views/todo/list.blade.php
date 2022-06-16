@extends('layouts.app-todo')

@php
    use App\Models\Todo; 
@endphp
{{-- @push('styles')
    <link rel="stylesheet" href="{{mix('css/main.css')}}"/>
@endPush --}}

@section('body')
    @forelse(Todo::all() as $todoRecord)
        @php
            $todo = $todoRecord->id;
            $redirect = asset('todos/list');
            $deletePath = asset("todos/delete/$todo"."?redirect=$redirect");
        @endphp
            <x-todo.item title="{{$todoRecord->title}}" status="{{$todoRecord->status}}" description="{{$todoRecord->description}}" due="{{$todoRecord->due}}" :delete-path="$deletePath"/>
        @empty
            <x-todo.empty/>
    @endforelse
@endsection