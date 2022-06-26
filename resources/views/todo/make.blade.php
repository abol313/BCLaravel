@extends('layouts.app-todo')

@section('title',__("todo.form.make.form_title"))

{{-- @push('styles')
    <link rel="stylesheet" href="{{asset('css/todo_make.css')}}"/>
@endPush --}}

@section('body')
    <h2 class="form-todo-make-title">@lang("todo.form.make.form_title")</h2>
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
    {{-- @elseif($errors->any())
        <div class="todo-message todo-message-unsucceed">
            @foreach($errors->all() as $error)
                <h2>{{$error}}</h2>
            @endforeach
        </div> --}}
    @endif
    <form action="{{route('todo.store')}}" method="post" class="form-todo-make">
        @csrf
        <label for="input_title" class="label-title" >@lang('todo.form.make.title')</label>
        <input id="input_title" name="title" class="input-title @error('title') input-validation-error  @enderror" placeholder="{{__("todo.form.make.title_placeholder")}}" value="{{$attributes['title'] ?? old('title')}}" required/>
        @error('title')
            <div class="todo-message message-validation-error">
                <h2>{{$message}}</h2>
            </div>
        @enderror

        <label for="textarea_description" class="label-description">@lang('todo.form.make.description')</label>
        <textarea id="textarea_description" name="description" class="textarea-description custom-scroll @error('description') input-validation-error  @enderror" rows="5" placeholder="{{__("todo.form.make.description_placeholder")}}" required>{{$attributes['description'] ?? old('description')}}</textarea>
        @error('description')
            <div class="todo-message message-validation-error">
                <h2>{{$message}}</h2>
            </div>
        @enderror

        <label for="input_due" class="label-due">@lang('todo.form.make.due')</label>
        <input id="input_due" name="due" type="datetime-local" class="input-due @error('due') input-validation-error  @enderror" placeholder="{{__("todo.form.make.due_placeholder")}}" value="{{$attributes['due'] ?? old('due')}}"/>
        @error('due')
            <div class="todo-message message-validation-error">
                <h2>{{$message}}</h2>
            </div>
        @enderror


        <label for="input_commander" class="label-commander">@lang('todo.form.make.commander')</label>
        {{-- <input id="input_commander" name="commander" list="list_users" class="input-commander" placeholder="@@Set the commander (whos make this todo)" pattern="@.*" title="unique name must be started with @ character" value="{{$attributes['commander'] ?? null}}" required/> --}}
        <input id="input_commander" name="commander" type="email" list="list_users" class="input-commander @error('commander') input-validation-error  @enderror" placeholder="{{__("todo.form.make.commander_placeholder")}}" title="unique name must be started with @ character" value="{{$attributes['commander'] ?? old('commander')}}" autocomplete="off" required/>
        @error('commander')
            <div class="todo-message message-validation-error">
                <h2>{{$message}}</h2>
            </div>
        @enderror

        <label for="input_soldier" class="label-soldier">@lang('todo.form.make.soldier')</label>
        {{-- <input id="input_soldier" name="soldier" list="list_users" class="input-soldier" placeholder="@@Set your soldier (whos will get this todo)" pattern="@.*" title="unique name must be started with @ character" value="{{$attributes['soldier'] ?? null}}" required/> --}}
        <input id="input_soldier" name="soldier" type="email" list="list_users" class="input-soldier @error('soldier') input-validation-error  @enderror" placeholder="{{__("todo.form.make.soldier_placeholder")}}" title="unique name must be started with @ character" value="{{$attributes['soldier'] ?? old('soldier')}}" autocomplete="off" required/>
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

        <input type="reset" class="reset" value="{{__("todo.form.make.form_reset")}}"/>
        <input type="submit" class="submit" value="{{__("todo.form.make.form_submit")}}" />
    </form>
@endSection