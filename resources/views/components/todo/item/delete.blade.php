@aware(['deletePath'])
<div class="delete">
    <a href="{{$deletePath}}" onclick='return confirm("{{__("todo.sure")}}")'>
        <h2>
            @lang("todo.todo.delete")
        </h2>
    </a>
</div>