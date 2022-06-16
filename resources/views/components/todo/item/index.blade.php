@props([
    'id'=> null
    'title' => 'Title',
    'status' => 'Status',
    'description' => 'Description',
    'due' => '2022-12-20 00:00:00',
])
@php
    if($todo ?? null){
        $id = $todo->id;
        $title = $todo->title;
        $status = $todo->status;
        $description = $todo->description;
        $due = $todo->due;
    }

    $deletePath = $id? route("route.todo.delete",['id'=>$id]):null;
@endphp
<div  {{ $attributes->class(['todo-item']) }}>
    <x-todo.item.container>
        <x-todo.item.title value="{{ $title }}" />
        <x-todo.item.status value="{{ $status }}" />
        <x-todo.item.description value="{{ $description }}" />
        @unless(empty($due))
            <x-todo.item.due value="{{ $due }}" />
        @endunless
        @if($deletePath)
            <x-todo.item.delete :delete-path="$deletePath"/>
        @endif
    </x-todo.item.container>
</div>
