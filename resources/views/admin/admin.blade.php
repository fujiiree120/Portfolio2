@extends('layouts.default')

@section('title', $title)

@section('content')
    <div class="container">
        <div class="form-area">
            <form method="post" action="{{ action('TriviaController@create_trivia', \Auth::user()->id) }}" enctype="multipart/form-data" class="trivia-post-form">
                {{ csrf_field() }}
                <p>新しいジャンルを入れてください</p>
                <p>
                    <input type="text" name="genre">
                </p>
                <p>
                    <input type="submit" value="ジャンルを追加する" class="btn btn-primary">
                </p>
            </form>
        </div>
    </div>
@endsection