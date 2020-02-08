@extends('layouts.default')

@section('title', $title)

@section('content')
    <div class="container">
    <h1>{{ $title }}</h1>
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
            </div>
        </div>
    </div>
@endsection