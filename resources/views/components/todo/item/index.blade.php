@props([
    'title' => 'Title',
    'status' => 'Status',
    'description' => 'Description',
    'due' => '2022-12-20 00:00:00',
])

<div  {{ $attributes->class(['todo-item']) }}>
    <x-todo.item.container>
        <x-todo.item.title value="{{ $title }}" />
        <x-todo.item.status value="{{ $status }}" />
        <x-todo.item.description value="{{ $description }}" />
        @unless(empty($due))
            <x-todo.item.due value="{{ $due }}" />
        @endunless
    </x-todo.item.container>
</div>
