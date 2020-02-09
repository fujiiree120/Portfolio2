@extends('layouts.default')

@section('title', $title)

@section('content')
    <div class="container">
    <h1>{{ $title }}</h1>
        <div class="form-area">
            <form method="post" action="{{ action('TriviaController@create_trivia', \Auth::user()->id) }}" enctype="multipart/form-data" class="trivia-post-form">
                {{ csrf_field() }}
                <p>豆知識の内容を入力してください(20文字以内)</p>
                <p>
                    <input type="text" name="name">
                </p>
                <p>内容の詳細を入力してください(200文字以内)</p>
                <p>
                    <textarea name="body" rows="4" cols="50"></textarea>
                </p>
                <p>
                    <input type="submit" value="豆知識を投稿する" class="btn btn-primary">
                </p>
            </form>
        </div>
        <p>現在の豆知識総数: <span class="trivia-count">{{ $trivia_count }}</span></p>
        <div class="table-responsive user-trivia-table">
            <table class="table table-borderd text-center table-striped">
                <thead class="thead-light">
                    <tr>
                        <th>豆知識タイトル</th>
                        <th>内容・補足</th>
                        <th>ジャンル</th>
                        <th>高評価</th>
                        <th>低評価</th>
                        <th>削除</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($trivias as $trivia)
                    <tr>
                        <td>
                            <form method="post" action="{{ action('TriviaController@update_name', $trivia->id) }}">
                                {{ csrf_field() }}
                                {{ method_field('patch') }}
                                <div class="form-group">
                                    <input  type="text" name="name" value="{{ $trivia->name }}">
                                    <input type="submit" value="変更" class="btn btn-sm btn-info">
                                </div>
                            </form>
                        </td>
                        <td>
                            <form method="post" action="{{ action('TriviaController@update_body', $trivia->id) }}">
                                {{ csrf_field() }}
                                {{ method_field('patch') }}
                                <div class="form-group">
                                    <input  type="text" name="body" value="{{ $trivia->body }}">
                                    <input type="submit" value="変更" class="btn btn-sm btn-info">
                                </div>
                            </form>
                        </td>
                        <td>
                            <form method="post" action="{{ action('TriviaController@update_genre', $trivia->id) }}">
                                {{ csrf_field() }}
                                {{ method_field('patch') }}
                                <div class="form-group">
                                    <select name="genre_id">
                                        <option value=""></option>
                                        @forelse ( $genre as $value )
                                            @if(!isset($trivia->genre->genre_id) )
                                                <option value="{{ $value->id }}">{{ $value->genre }}</option>
                                            @elseif($trivia->genre->genre_id === $value->id)
                                                <option value="{{ $value->id }}" selected>{{ $value->genre }}</option>
                                            @else
                                                <option value="{{ $value->id }}">{{ $value->genre }}</option>
                                            @endif
                                        @empty
                                        @endforelse
                                    </select>   
                                    <input type="submit" value="編集" class="btn btn-sm btn-info">
                                </div>
                            </form>
                        </td>
                        <td>{{ $trivia->vote_up }}</td>
                        <td>{{ $trivia->vote_down }}</td>
                        <td>
                            <form method="post" action="{{ action('TriviaController@destroy_trivia', $trivia->id) }}">
                                {{ csrf_field() }}
                                {{ method_field('delete') }}
                                <div class="form-group">
                                    <input type="submit" value="削除" class="btn btn-danger">
                                </div> 
                            </form>
                        </td>
                    </tr>
                @empty
                    <p>豆知識がありません。</p>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection