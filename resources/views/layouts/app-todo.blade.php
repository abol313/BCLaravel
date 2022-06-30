<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title',__("todo.title"))</title>

    <!--site-icon-->
    <link rel="shortcut icon" href="{{mix('images/todo_icon.png')}}"/>

    <!--fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet"/>
    @stack('fonts')

    <!--styles-->
    <link rel="stylesheet" href="{{mix('css/todo_app.css')}}"/>
    @if($locale==="fa" || 0)
        <link rel="stylesheet" href="{{mix('css/lang_fa.css')}}"/>
    @endif
    @stack('styles')

    <script src="{{mix('js/bootstrap.js')}}"></script>

</head>
<body>
    <header>
        <div>
            <h1>@lang("todo.welcome")</h1>
            <div class="languages">
                <a href="{{route('setLocale',['locale'=>'fa'])}}" @if($locale==="fa") class="enabled" @endif>فا</a>
                <a href="{{route('setLocale',['locale'=>'en'])}}" @if($locale==="en") class="enabled" @endif>en</a>
            </div>
        </div>
        <nav>
            <ul class="hypers">
                <a href="{{route('todo.listAll')}}"><li><h2>@lang("todo.list")</h2></li></a>
                <a href="{{route('todo.create')}}"><li><h2>@lang("todo.make")</h2></li></a>
            </ul>
        </nav>
    </header>
    <main>
        @section('body')
            <h1>Welcome to the Laravel</h1>
        @show
    </main>
    <footer>
        <hr/>
        <h1>@lang("todo.made")</h1>
    </footer>

    <script src="{{mix('js/todoManager.js')}}" defer></script>
</body>
</html>

