@props([
    'todo'=>null,
    'id'=> null,
    'title' => 'Title',
    'status' => 'Status',
    'description' => 'Description',
    'due' => '2022-12-20 00:00:00',
])
@php
    if($todo){
        $id = $todo->id;
        $title = $todo->title;
        $status = $todo->status;
        $description = $todo->description;
        $due = $todo->due;
    }

    $deletePath = $id? route("todo.delete",['todo'=>$todo]):null;
    $editPath = $id? route("todo.editView",[$todo]):null;
@endphp
<div  {!! $attributes->class(['todo-item']) !!}>
    <x-todo.item.container>
        <x-todo.item.title value="{!! $title !!}" />

        <x-todo.item.status value="{!! $status !!}" />

        <x-todo.item.description value="{!! $description !!}" />

        @unless(empty($due))
            <x-todo.item.due value="{!! $due !!}" />
        @endunless

        @if($editPath)
            <x-todo.item.edit :edit-path="$editPath"/>
        @endif
        
        @if($deletePath)
            <x-todo.item.delete :delete-path="$deletePath"/>
        @endif
    </x-todo.item.container>
</div>
