@extends('layouts.app-todo')

@section('title','Edit Todo')

{{-- @push('styles')
    <link rel="stylesheet" href="{{asset('css/todo_make.css')}}"/>
@endPush --}}

@section('body')
    <h2 class="form-todo-make-title">Edit a todo !</h2>
    @php

        $report = session('report');
        $success = $report['success'] ?? null;
        $message = $report['message'] ?? null;
        $attributes = $report['attributes'] ?? null;
    @endphp
    @if($success === true)
        <div class="todo-message todo-message-succeed">
            <h2>{{$message}}</h2>
        </div>
    @elseif($success === false)
        <div class="todo-message todo-message-unsucceed">
            <h2>{{$message}}</h2>
        </div>
    @elseif($errors->any())
        <div class="todo-message todo-message-unsucceed">
            @foreach($errors->all() as $error)
                <h2>{{$error}}</h2>
            @endforeach
        </div>
    @endif
    
    <form action="{{route('todo.editAPI',[$todo])}}" method="post" class="form-todo-make">
        @csrf
        <label for="input_title" class="label-title" >Title</label>
        <input id="input_title" name="title" class="input-title" placeholder="Choose your title of todo" value="{{$attributes['title'] ?? old('title') ?? $todo->getAttribute('title') }}" required/>

        <label for="textarea_description" class="label-description">Description</label>
        <textarea id="textarea_description" name="description" class="textarea-description custom-scroll" rows="5" placeholder="Give descriptions..." required>{{$attributes['description'] ?? old('description') ?? $todo->getAttribute('description')}}</textarea>

        <label for="input_due" class="label-due">Due (time)</label>
        <input id="input_due" name="due" type="datetime-local" class="input-due" placeholder="Set the time should to be done" value="{{str_replace(' ','T',$attributes['due'] ?? old('due') ?? $todo->getAttribute('due'))}}"/>

        <label for="input_commander" class="label-commander">Commander</label>
        {{-- <input id="input_commander" name="commander" list="list_users" class="input-commander" placeholder="@@Set the commander (whos make this todo)" pattern="@.*" title="unique name must be started with @ character" value="{{$attributes['commander'] ?? null}}" required/> --}}
        <input id="input_commander" name="commander" type="email" list="list_users" class="input-commander" placeholder="Set the commander (whos make this todo)" title="unique name must be started with @ character" value="{{$attributes['commander'] ?? old('commander') ?? $commander ?? null}}" autocomplete="off" required/>

        <label for="input_soldier" class="label-soldier">Soldier</label>
        {{-- <input id="input_soldier" name="soldier" list="list_users" class="input-soldier" placeholder="@@Set your soldier (whos will get this todo)" pattern="@.*" title="unique name must be started with @ character" value="{{$attributes['soldier'] ?? null}}" required/> --}}
        <input id="input_soldier" name="soldier" type="email" list="list_users" class="input-soldier" placeholder="Set your soldier (whos will get this todo)" title="unique name must be started with @ character" value="{{$attributes['soldier'] ?? old('soldier') ?? $soldier ?? null}}" autocomplete="off" required/>

        <datalist id="list_users">
            @foreach(\App\Models\User::all() as $user)
                {{-- <option value="{{$user->unique_name}}"/> --}}
                <option value="{{$user->email}}"/>
            @endForeach
        </datalist>

        <input type="reset" class="reset" value="Clean"/>
        <input type="submit" class="submit" value="Edit !" />
    </form>
@endSection