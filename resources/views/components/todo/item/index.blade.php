<x-todo.item.container {{$attributes->class(['todo-item'])}}>
    <x-todo.item.title value="{{$title}}"/>
    <x-todo.item.status value="{{$status}}"/>
    <x-todo.item.description value="{{$description}}"/>
    <x-todo.item.due value="{{$due}}"/>
</x-todo.item.container>