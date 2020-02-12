@extends('layouts.default')

@section('title', $title)

@section('content')
    <div class="container">
    <h1>{{ $title }}</h1>
    <p>このサイトはあなたが知っている雑学を共有し、皆で評価しあうSNSサービスです</p>
    <p>左上のユーザー管理画面から投稿することができます</p>
        <div class="row index-body">
            <div class="col-md-3 sticky order-md-2">
                <aside>
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
                        <div class="card-body">
                            <p>ジャンルで探す</p>
                            @forelse($genre as $value)
                            <div>
                                <form method="get" action="{{ action('TriviaController@index', $value->id) }}" class="form-inline">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <button type="submit" name="genre" value="{{ $value->id }}" class="genre-btn btn btn-sm btn-secondary">{{ $value->genre }}</button>
                                    </div>
                                </form>
                            </div>  
                            @empty
                            @endforelse
                        </div>
                    </div>
                </aside>
                <aside>
                    <div class="card">
                        <div class="card-header card-title">
                            ユーザーランキング
                        </div>
                        <div class="card-body">
                            @forelse($user_rank as $value)
                                <div class="side-list">
                                    <span>{{ $loop->index + 1 }}位</span>
                                    <a href="{{ action('TriviaController@show_user_trivia', $value->user_id) }}">{{ $value->user->name }}</a>
                                    <span>{{ $value->user_score }}点</span>
                                </div>
                            @empty
                            @endforelse
                            <a href="{{ action('TriviaController@show_user_rank') }}">もっとみる</a>
                        </div>
                    </div>
                </aside>
            </div>
            <article class="col-md-9 order-md-1">
                <div>
                    <form method="get" action="{{ action('TriviaController@index') }}"  class="text-left" name="my_form" id = "my_form">
                        {{ csrf_field() }}
                        <select name='trivia_order' id='order_by'>
                            <option value="created_desc" @if($order_by == 'created_desc') selected @endif>新着順</option>
                            <option value="vote_asc" @if($order_by == 'vote_asc') selected @endif>評価が高い順</option>
                        </select>
                        <script type="text/javascript" src="/js/order_by.js"></script>
                    </form>
                </div>
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
                                        <input type="submit" value="う～ん" name="vote" class="{{ $button_class_down }}">
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
        </div>
    </div>
@endsection