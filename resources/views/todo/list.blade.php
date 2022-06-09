@extends('layouts.app')
@pushOnce('styles')
    <link rel="stylesheet" href="{{asset('css/todo_item.css')}}"/>
@endPushOnce

@section('body')
    <x-todo.item title="Hello !!!">
        <x-slot:description>
            guyg
            ppji
            ejfipewfj
            jqofijoi
            wodijqpiudqhipud
            piuqhqpiuwdh            guyg
            ppji
            ejfipewfj
            jqofijoi
            wodijqpiudqhipud
            piuqhqpiuwdh            guyg
            ppji
            ejfipewfj
            jqofijoi
            wodijqpiudqhipud
            piuqhqpiuwdh
        </x-slot>
    </x-todo.item>
@endsection