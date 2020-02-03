@extends('layouts.default')

@section('title', $title)

@section('content')
    <div class="container">
        <div class="row index-body">
            <nav class="col-md-3">
                <div class="card">
                    <div class="card-header card-title">
                        検索結果
                    </div>
                    <div class="card-body">
                        <p>検索結果</p>
                    </div>
                </div>
            </nav>
            <article class="col-md-6">
                @forelse($trivias as $trivia)
                    <div classs="row">
                        <div class="card trivia-card">
                            <div class="card-body ">
                                <a href="{{ action('TriviaController@show_trivia_detail', $trivia->id) }}" class="card-body-name">{{ $trivia->name }}</a>
                                <p>Made by <a href="">{{ $trivia->user->name }}</a></p>
                                <div class="trivia-vote">
                                    <form method="post" action="{{ action('VoteController@is_valid_trivia_vote') }}"  class="text-right">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{ $trivia->id }}" name="id">
                                        <input type="submit" value="へー:" name="vote" class="vote-button">
                                        <span class="vote-up">{{$trivia->vote_up }}</span>
                                        <input type="submit" value="ちがうよ:" name="vote" class="vote-button">
                                        <span class="vote-down">{{$trivia->vote_down }}</span>
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
                <div class="card">
                    <div class="card-header card-title">
                        ユーザーランキング
                    </div>
                    <div class="card-body">
                        <p>ユーザーランキング</p>
                    </div>
                </div>
            </aside>
        </div>
    </div>
@endsection