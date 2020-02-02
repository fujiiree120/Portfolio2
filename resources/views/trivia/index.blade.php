@extends('layouts.default')

@section('title', $title)

@section('content')
    <div class="container">
        <div class="row">
            <nav class="col-md-3">
                <p>検索条件など</p>
            </nav>
            <article class="col-md-6">
                <p>メインの豆知識</p>

                        @forelse($trivias as $trivia)
                        <div classs="row">
                            <div class="card trivia-card">
                                <div class="card-body">
                                    <a href="{{ url('/') }}">{{ $trivia->name }}</a>
                                    <p>Made by {{ $trivia->user->name }}</p>
                                    <div class="trivia-vote">
                                        <form method="get" action=""  class="text-right" name="myform" id = "my_form">
                                            {{ csrf_field() }}
                                            <input type="submit" value="へー:" class="vote-button">
                                            <span class="vote-up">{{$trivia->vote_up }}</span>
                                            <!-- <script type="text/javascript" src="/js/index.js"></script> -->
                                        </form>
                                        <form method="get" action=""  class="text-right" name="myform" id = "my_form">
                                            {{ csrf_field() }}
                                            <input type="submit" value="ちがうよ:" class="vote-button">
                                            <span class="vote-down">{{$trivia->vote_down }}</span>
                                            <!-- <script type="text/javascript" src="/js/index.js"></script> -->
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                            <p>豆知識はありません。</p>
                        @endforelse
            </article>
            <aside class="col-md-3">
                <p>ユーザーランキング</p>
            </aside>
        </div>
    </div>
@endsection