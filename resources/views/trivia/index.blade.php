@extends('layouts.default')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>
    <div class="container">
        <div class="row index-body">
            <nav class="col-md-3">
                <div class="card">
                    <div class="card-header card-title">
                        雑学を探す
                    </div>
                    <div class="card-body">
                        <form method="get" action="{{ action('TriviaController@index') }}" class="form-inline">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <input  type="text" name="keyword" class="text-field" value="{{ $keyword }}" placeholder="キーワードで検索">
                                <button type="submit" class="btn btn-sm btn-info">検索</button>
                            </div>
                        </form>
                    </div>
                    
                </div>
            </nav>
            <article class="col-md-6">
                @forelse($trivias as $trivia)
                    @forelse($user_votes as $user_vote)
                        @if($user_vote->trivia_id === $trivia->id && $user_vote->vote_up == true)
                            <?php
                                $button_class_up="vote-button-hover";
                                $button_class_down="vote-button";
                                break;
                            ?>
                        @elseif($user_vote->trivia_id === $trivia->id && $user_vote->vote_down == true)
                            <?php
                                $button_class_up="vote-button";
                                $button_class_down="vote-button-hover";
                                break;
                            ?>
                        @else
                            <?php
                                $button_class_up="vote-button";
                                $button_class_down="vote-button";
                            ?>    
                        @endif
                    @empty
                            <?php
                                $button_class_up="vote-button";
                                $button_class_down="vote-button";
                            ?>    
                    @endforelse
                    <div classs="row">
                        <div class="card trivia-card">
                            <div class="card-body ">
                                <a href="{{ action('TriviaController@show_trivia_detail', $trivia->id) }}" class="card-body-name">{{ $trivia->name }}</a>
                                <p>Made by <a href="{{ action('TriviaController@show_user_trivia', $trivia->user_id) }}">{{ $trivia->user->name }}</a></p>
                                <div class="trivia-vote">
                                    <form method="post" action="{{ action('VoteController@is_valid_trivia_vote') }}"  class="text-right">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{ $trivia->user_id }}" name="user_id">
                                        <input type="hidden" value="{{ $trivia->id }}" name="id">
                                        <input type="submit" value="へー:" name="vote" class="{{ $button_class_up }}">
                                        <span class="vote-up">{{$trivia->vote_up }}</span>
                                        <input type="submit" value="ちがうよ:" name="vote" class="{{ $button_class_down }}">
                                        <span class="vote-down">{{$trivia->vote_down }}</span>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>雑学はありません。</p>
                @endforelse
            </article>
            <aside class="col-md-3">
                <div class="card">
                    <div class="card-header card-title">
                        ユーザーランキング
                    </div>
                    <div class="card-body">
                        @forelse($user_rank as $value)
                            <div class="user_rank">
                                <span>{{ $loop->index + 1 }}位</span>
                                <a href="{{ action('TriviaController@show_user_trivia', $value->user_id) }}" class="user_rank_name">{{ $value->user->name }}</a>
                                <span>{{ $value->user_score }}点</span>
                            </div>
                        @empty
                        @endforelse
                        <a href="">もっとみる</a>
                    </div>
                </div>
            </aside>
        </div>
    </div>
@endsection