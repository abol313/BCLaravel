@extends('layouts.app-todo')

@php
    use App\Models\Todo; 
@endphp
{{-- @push('styles')
    <link rel="stylesheet" href="{{mix('css/main.css')}}"/>
@endPush --}}

@section('body')
    @forelse($todos as $todo)
        <x-todo.item :todo="$todo"/>
    @empty
        <x-todo.empty/>
    @endforelse
@endsection