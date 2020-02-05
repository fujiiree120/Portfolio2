@extends('layouts.default')

@section('title', $title)

@section('content')
    <div class="container">
        <div class="trivia-detail-article">
            <h1 class="trivia-title">{{ $title }}</h1>
            <p>Made by <a href="">{{ $trivia_detail->user->name }}</a></p>
            <p class="trivia-body">{!! nl2br(e($trivia_detail->body)) !!}</p>
        </div>
        <div class="trivia-vote">
            <form method="post" action="{{ action('VoteController@is_valid_trivia_vote') }}"  class="text-right">
                {{ csrf_field() }}
                <input type="hidden" value="{{ $trivia_detail->user_id }}" name="user_id">
                <input type="hidden" value="{{ $trivia_detail->id }}" name="id">
                <input type="submit" value="へー:" name="vote" class="{{ $class_button_up }}">
                <span class="vote-up">{{$trivia_detail->vote_up }}</span>
                <input type="submit" value="ちがうよ:" name="vote" class="{{ $class_button_down }}">
                <span class="vote-down">{{$trivia_detail->vote_down }}</span>
            </form>
        </div>
    </div>
@endsection