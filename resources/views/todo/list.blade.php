@extends('layouts.app')

@php
    use App\Models\Todo;
    
@endphp
@push('styles')
    <link rel="stylesheet" href="{{mix('css/main.css')}}"/>
@endPush

@section('body')
    @forelse(Todo::all() as $todoRecord)
        @php
            $todo = $todoRecord->id;
            $redirect = asset('todoes/list');
            $deletePath = asset("todoes/delete/$todo"."?redirect=$redirect");
        @endphp
        <x-todo.item title="{{$todoRecord->title}}" status="{{$todoRecord->status}}" description="{{$todoRecord->description}}" due="{{$todoRecord->due}}" :delete-path="$deletePath"/>
    @empty
        <h1 class="no-todo-item">No todo !</h1>
    @endforelse
@endsection