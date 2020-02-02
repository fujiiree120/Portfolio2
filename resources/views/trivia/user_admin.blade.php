@extends('layouts.default')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>
    <div>
        <form method="post" action="{{ action('TriviaController@create_trivia', \Auth::user()->id) }}" enctype="multipart/form-data" class="trivia-post-form">
            {{ csrf_field() }}
            <p>
                <p>豆知識の内容を入力してください(20文字以内)</p>
                <input type="text" name="name">
            </p>
            <p>
                <p>内容の詳細を入力してください(200文字以内)</p>
                <input type="textarea" name="body">
            </p>
            <p>
                <input type="submit" value="豆知識を投稿する" class="btn btn-primary">
            </p>
        </form>
        <p>現在の豆知識総数: <span class="trivia-count">{{ $trivia_count }}</span></p>
        <table class="table table-hover table-borderd text-center">
            <thead class="thead-light">
                <tr>
                    <th>豆知識タイトル</th>
                    <th>内容・補足</th>
                    <th>高評価</th>
                    <th>低評価</th>
                    <th>編集</th>
                    <th>削除</th>
                </tr>
            </thead>
            <tbody>
            @forelse($trivias as $trivia)
                    <td>{{ $trivia->name }}</td>
                    <td>{{ $trivia->body }}</td>
                    <td>{{ $trivia->vote_up }}</td>
                    <td>{{ $trivia->vote_down }}</td>
                    <td>
                        <form method="get" action="">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <input type="hidden" name="name" value="{{ $trivia->id }}">
                                <input type="submit" value="編集する" class="btn btn-secondary">
                            </div>
                        </form>
                    </td>
                    <td>
                        <form method="post" action="">
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
@endsection