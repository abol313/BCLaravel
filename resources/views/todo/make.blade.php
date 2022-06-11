@extends('layouts.app')

@section('title','Make Todo')

@push('styles')
    <link rel="stylesheet" href="{{asset('css/todo_make.css')}}"/>
@endPush

@section('body')
    <h2 class="form-todo-make-title">Make a todo !</h2>
    @php
        $success = $success ?? null;
    @endphp
    @if($success === true)
        <div class="todo-message todo-message-succeed">
            <h2>{{$message}}</h2>
        </div>
    @elseif($success === false)
        <div class="todo-message todo-message-unsucceed">
            <h2>{{$message}}</h2>
        </div>
    @endif 
    <form class="form-todo-make">

        <label for="input_title" class="label-title" >Title</label>
        <input id="input_title" name="title" class="input-title" placeholder="Choose your title of todo" value="{{$attributes['title'] ?? null}}" required/>

        <label for="textarea_description" class="label-description">Description</label>
        <textarea id="textarea_description" name="description" class="textarea-description custom-scroll" rows="5" placeholder="Give descriptions..." required>{{$attributes['description'] ?? null}}</textarea>

        <label for="input_due" class="label-due">Due (time)</label>
        <input id="input_due" name="due" type="datetime-local" class="input-due" placeholder="Set the time should to be done" value="{{$attributes['due'] ?? null}}"/>

        <label for="input_commander" class="label-commander">Commander</label>
        <input id="input_commander" name="commander" list="list_users" class="input-commander" placeholder="@@Set the commander (whos make this todo)" pattern="@.*" title="unique name must be started with @ character" value="{{$attributes['commander'] ?? null}}" required/>

        <label for="input_soldier" class="label-soldier">Soldier</label>
        <input id="input_soldier" name="soldier" list="list_users" class="input-soldier" placeholder="@@Set your soldier (whos will get this todo)" pattern="@.*" title="unique name must be started with @ character" value="{{$attributes['soldier'] ?? null}}" required/>

        <datalist id="list_users">
            @foreach(\App\Models\User::all() as $user)
                <option value="{{'@'.$user->unique_name}}"/>
            @endForeach
        </datalist>
        <input type="reset" class="reset" value="Clean"/>
        <input type="submit" class="submit" value="Make !" />
    </form>
@endSection