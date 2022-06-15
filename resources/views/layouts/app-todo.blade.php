<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title','Todo Collection')</title>

    <!--site-icon-->
    <link rel="shortcut icon" href="{{mix('images/todo_icon.png')}}"/>

    <!--fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet"/>
    @stack('fonts')

    <!--styles-->
    <link rel="stylesheet" href="{{mix('css/todo_app.css')}}"/>
    @stack('styles')

</head>
<body>
    <header>
        <h1>Welcome to Todo-Collection</h1>
        <nav>
            <ul class="hypers">
                <a href="{{asset('/todos/list')}}"><li><h2>List</h2></li></a>
                <a href="{{asset('/todos/make')}}"><li><h2>Make</h2></li></a>
            </ul>
        </nav>
    </header>
    @section('body')
        <h1>Welcome to the Laravel</h1>
    @show
    @yield('content')
    <footer>
        <hr/>
        <h1>Made with interseting ;)</h1>
    </footer>
</body>
</html>

