@extends('layouts.app-todo')

@section('title',__("todo.form.edit.form_title"))

{{-- @push('styles')
    <link rel="stylesheet" href="{{asset('css/todo_make.css')}}"/>
@endPush --}}

@section('body')
    <h2 class="form-todo-make-title">@lang('todo.form.edit.form_title')</h2>
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
    @endif
    
    <form action="{{route('todo.update',[$todo])}}" method="post" class="form-todo-make">
        @csrf
        <label for="input_title" class="label-title" >@lang('todo.form.edit.title')</label>
        <input id="input_title" name="title" class="input-title @error('title') input-validation-error  @enderror" placeholder="{{__('todo.form.edit.title_placeholder')}}" value="{{$attributes['title'] ?? old('title') ?? $todo->getAttribute('title') }}" required/>
        @error('title')
            <div class="todo-message message-validation-error">
                <h2>{{$message}}</h2>
            </div>
        @enderror

        <label for="textarea_description" class="label-description">@lang('todo.form.edit.description')</label>
        <textarea id="textarea_description" name="description" class="textarea-description custom-scroll @error('description') input-validation-error  @enderror" rows="5" placeholder="{{__("todo.form.edit.description_placeholder")}}" required>{{$attributes['description'] ?? old('description') ?? $todo->getAttribute('description')}}</textarea>
        @error('description')
            <div class="todo-message message-validation-error">
                <h2>{{$message}}</h2>
            </div>
        @enderror

        <label for="input_due" class="label-due">@lang('todo.form.edit.due')</label>
        <input id="input_due" name="due" type="datetime-local" class="input-due @error('due') input-validation-error  @enderror" placeholder="{{__("todo.form.edit.due_placeholder")}}" value="{{str_replace(' ','T',$attributes['due'] ?? old('due') ?? $todo->getAttribute('due'))}}" step="any"/>
        @error('due')
            <div class="todo-message message-validation-error">
                <h2>{{$message}}</h2>
            </div>
        @enderror

        <label for="input_commander" class="label-commander">@lang('todo.form.edit.commander')</label>
        {{-- <input id="input_commander" name="commander" list="list_users" class="input-commander" placeholder="@@Set the commander (whos make this todo)" pattern="@.*" title="unique name must be started with @ character" value="{{$attributes['commander'] ?? null}}" required/> --}}
        <input id="input_commander" name="commander" type="email" list="list_users" class="input-commander @error('commander') input-validation-error  @enderror" placeholder="{{__("todo.form.edit.commander_placeholder")}}" title="unique name must be started with @ character" value="{{$attributes['commander'] ?? old('commander') ?? $commander ?? null}}" autocomplete="off" required/>
        @error('commander')
            <div class="todo-message message-validation-error">
                <h2>{{$message}}</h2>
            </div>
        @enderror

        <label for="input_soldier" class="label-soldier">@lang('todo.form.edit.soldier')</label>
        {{-- <input id="input_soldier" name="soldier" list="list_users" class="input-soldier" placeholder="@@Set your soldier (whos will get this todo)" pattern="@.*" title="unique name must be started with @ character" value="{{$attributes['soldier'] ?? null}}" required/> --}}
        <input id="input_soldier" name="soldier" type="email" list="list_users" class="input-soldier @error('soldier') input-validation-error  @enderror" placeholder="{{__("todo.form.edit.soldier_placeholder")}}" title="unique name must be started with @ character" value="{{$attributes['soldier'] ?? old('soldier') ?? $soldier ?? null}}" autocomplete="off" required/>
        @error('soldier')
            <div class="todo-message message-validation-error">
                <h2>{{$message}}</h2>
            </div>
        @enderror

        <datalist id="list_users">
            @foreach(\App\Models\User::all() as $user)
                {{-- <option value="{{$user->unique_name}}"/> --}}
                <option value="{{$user->email}}"/>
            @endForeach
        </datalist>

        <input type="reset" class="reset" value="{{__("todo.form.edit.form_reset")}}"/>
        <input type="submit" class="submit" value="{{__("todo.form.edit.form_submit")}}" />
    </form>
@endSection