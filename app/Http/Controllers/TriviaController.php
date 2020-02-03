<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trivia;

use App\Http\Requests\CreateTriviaRequest;

class TriviaController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $trivias = $this->get_all_trivias();
        $title = '豆知識一覧';
        return view('trivia.index',[
            'title' => $title,
            'trivias' => $trivias,
        ]);
    }

    private function get_all_trivias()
    {
        $get_all_trivias = Trivia::all();
        return $get_all_trivias;
    }

    public function show_user_admin()
    {
        $id = \Auth::user()->id;
        $trivias = $this->get_user_trivias($id);
        $trivia_count = count($trivias);
        $title = 'ユーザー画面';
        return view('trivia.user_admin',[
            'title' => $title,
            'trivias' => $trivias,
            'trivia_count' => $trivia_count,
        ]);
    }

    private function get_user_trivias($id)
    {
        $get_user_trivias = Trivia::where('user_id', $id)->get();
        return $get_user_trivias;
    }

    public function show_trivia_detail($id)
    {
        $trivia_detail = $this->get_trivia_detail($id);
        $title = $trivia_detail->name;
        return view('trivia.trivia_detail',[
            'title' => $title,
            'trivia_detail' => $trivia_detail,
        ]);
    }

    private function get_trivia_detail($id)
    {
        $get_trivia_detail = Trivia::where('id', $id)->first();
        return $get_trivia_detail;
    }

    public function create_trivia(CreateTriviaRequest $request)
    {
        //Triviaモデルを作成する処理
        $trivia = new Trivia();
        $trivia->name = $request->name;
        $trivia->body = $request->body;
        $trivia->vote_up = 0;
        $trivia->vote_down = 0;
        $trivia->user_id = \Auth::user()->id;
        $trivia->save();

        return redirect('/user/{trivia}')->with('flash_message', '豆知識を投稿しました');
    }
}
