<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/trivia.css">
    <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="//code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <title>@yield('title')</title>
</head>
<header>
    <nav class="navbar navbar-expand-sm navbar-light bg-light">
        <a class="navbar-brand text-primary" href="{{ url('/') }}">雑学王</a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#headerNav" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="ナビゲーションの切替">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="headerNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ action('TriviaController@show_user_index', \Auth::user()->id) }}">ユーザー画面</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ action('TriviaController@show_user_rank') }}">ユーザーランキング</a>
                </li>
                <li class="nav-item">
                    <form action="{{ url('/logout') }}" method="post" name="form1" >
                        {{ csrf_field() }}
                        <a href="javascript:form1.submit()" class="nav-link">ログアウト</a>
                    </form>
                </li>
                @if(Auth::user()->admin === 1)
                <li class="nav-item">
                    <a class="nav-link" href="{{ action('HomeController@show_admin') }}">管理画面</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{ action('HomeController@change_admin') }}">管理</a>
                </li>
            </ul>
        </div>
    </nav>
    <p>ようこそ　{{ Auth::user()->name }} さん</p>
</header>
<body>
    @if (session('flash_error'))
        <div class="alert alert-danger">
            {{ session('flash_error') }}
        </div>
    @endif
    @foreach($errors->all() as $error)
        <div class="alert alert-danger">
            {{ $error }}
        </div>
    @endforeach
    @if (session('flash_message'))
        <div class="alert alert-success">
            {{ session('flash_message') }}
        </div>
    @endif
    @yield('content')
</body>
</html>