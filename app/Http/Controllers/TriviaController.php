<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trivia;
use App\VoteUserStatus;
use App\UserRank;

use App\Http\Requests\CreateTriviaRequest;
use App\Http\Requests\UpdateNameRequest;
use App\Http\Requests\UpdateBodyRequest;

class TriviaController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if(!empty($request->keyword)){
            $trivias = $this->get_search_trivias($request->keyword);
        }else{
            $trivias = $this->get_all_trivias();
        }

        $id = \Auth::user()->id;
        $title = '雑学一覧';
        $user_votes = $this->get_all_user_status($id);
        $user_rank = $this->get_user_rank();
        return view('trivia.index',[
            'title' => $title,
            'trivias' => $trivias,
            'user_votes' => $user_votes,
            'user_rank' => $user_rank,
            'keyword' => $request->keyword,
        ]);
    }

    private function get_search_trivias($keyword)
    {
        //キーワードに合致する商品を$triviasに格納し、index.phpで表示
        $get_search_trivias = Trivia::where('name',  'like', '%'.$keyword.'%')->orWhere('body', 'like', '%'.$keyword.'%')->get();

        // $trivias = $get_all_trivias->whereHas('name', function ($query) use ($keyword){
        //     $query->where('name',  'like', '%'.$keyword.'%');
        // })->orWhere('body', 'like', '%'.$keyword.'%')->get();

        return $get_search_trivias;
    }

    public function show_user_trivia($user_id)
    {
        $id = \Auth::user()->id;
        $user_trivia = Trivia::where('user_id',$user_id)->get();
        $user_votes = $this->get_all_user_status($id);
        //$user_status = UserRank::where('user_id', $user_id)->first();

        $user_status = $this->get_user_rank();
        $i = 0;
        foreach($user_status as $value){
            if($value->user_id == $user_id){
                $user_rank = $i + 1;
                $user_score = $value->user_score;
                $title = $value->user->name.'さんのマイページ';
            break;
            }
            $i ++;
        }
        return view('trivia.user_my_page',[
            'title' => $title,
            'trivias' => $user_trivia,
            'user_rank' => $user_rank,
            'user_score' => $user_score,
            'user_votes' => $user_votes,
        ]);
    }

    private function get_user_rank()
    {
        $user_rank = UserRank::orderBy('user_score', 'desc')->get();
        return $user_rank;
;    }

    private function get_all_trivias()
    {
        $get_all_trivias = Trivia::all();
        return $get_all_trivias;
    }

    private function get_all_user_status($id)
    {
        $get_user_status = VoteUserStatus::where('user_id', $id)->get();
        return $get_user_status;
    }

    public function show_user_index()
    {
        $id = \Auth::user()->id;
        $trivias = $this->get_user_trivias($id);
        $trivia_count = count($trivias);
        $title = 'ユーザー画面';
        return view('trivia.user_index',[
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
        $user_id = \Auth::user()->id;
        $user_vote = $this->get_user_status($id, $user_id);
        $trivia_detail = $this->get_trivia_detail($id);
        if(!empty($user_vote)){
            if($user_vote->vote_up == true){
                $class_button_up = "vote-button-detail-hover";
                $class_button_down = "vote-button-detail";
            }else if($user_vote->vote_down == true){
                $class_button_up = "vote-button-detail";
                $class_button_down = "vote-button-detail-hover";
            }else{
                $class_button_up = "vote-button-detail";
                $class_button_down = "vote-button-detail";
            }
        }else{
            $class_button_up = "vote-button-detail";
            $class_button_down = "vote-button-detail";
        }

        $title = $trivia_detail->name;
        return view('trivia.trivia_detail',[
            'title' => $title,
            'trivia_detail' => $trivia_detail,
            'class_button_up' =>$class_button_up,
            'class_button_down' =>$class_button_down,
        ]);
    }

    private function get_user_status($id, $user_id)
    {
        $get_user_status = VoteUserStatus::where('user_id', $user_id)->where('trivia_id', $id)->first();
        return $get_user_status;
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

        return redirect('/user/{trivia}')->with('flash_message', '雑学を投稿しました');
    }

    public function update_name(Trivia $trivia, UpdateNameRequest $request)
    {
        $trivia->name = $request->name;
        $trivia->save();
        return redirect('/user/{trivia}')->with('flash_message', 'タイトルを変更しました');
    }

    public function update_body(Trivia $trivia, UpdateBodyRequest $request)
    {
        $trivia->body = $request->body;
        $trivia->save();
        return redirect('/user/{trivia}')->with('flash_message', '内容を変更しました');
    }

    public function destroy_trivia(Trivia $trivia)
    {
        $trivia->delete();
        return redirect('/user/{trivia}')->with('flash_message', '雑学を削除しました');
    }
}
