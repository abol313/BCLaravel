@extends('layouts.app')

@section('title', 'LaraWelcome')

@section('body')
    @parent
    <x-dialog title="Welcome">
        <h1><i>Welcome to you :)</i></h1>
    </x-dialog>
@endsection
