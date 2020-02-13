@extends('layouts.default')

@section('title', $title)

@section('content')
    <div class="container">
        <h1>{{ $title }}</h1>
        <p>現在の順位: <span class="user-score"> {{ $user_rank }} </span>位</p>
        <p>現在のユーザースコアは <span class="user-score"> {{ $user_score }} </span> 点です</p>
        <article class="col-md-8 offset-md-2">
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
                                        <input type="submit" value="へ～" name="vote" class="{{ $button_class_up }}">
                                        <span class="vote-up">{{$trivia->vote_up }}</span>
                                        <input type="submit" value="う～ん" name="vote" class="{{ $button_class_down }}">
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
    </div>
@endsection