@extends('layouts.default')

@section('title', $title)

@section('content')
    <div class="container">
        <div class="form-area">
            <form method="post" action="{{ action('TriviaController@create_genre') }}" enctype="multipart/form-data" class="trivia-post-form">
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
        <table class="table table-hover table-borderd text-center">
            <thead class="thead-light">
                <tr>
                    <th>ジャンルタイトル</th>
                </tr>
            </thead>
            <tbody>
            @forelse($genre as $value)
                <tr>
                    <td>{{ $value->genre }}</td>
                </tr>
            @empty
                <p>豆知識がありません。</p>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection