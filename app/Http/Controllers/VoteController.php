<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trivia;
use App\VoteUserStatus;
use DB;
class VoteController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function is_valid_trivia_vote(Request $request)
    {
        if($request->vote === "へー:"){
            $vote = 'vote_up';
            $this->update_trivia_vote($request->id, $vote);
        }else if($request->vote === "ちがうよ:"){
            $vote = 'vote_down';
            $this->update_trivia_vote($request->id, $vote);
        }else{
            return redirect('/')->with('flash_error', '値が不正です');
        }
        return back()->with('flash_message', '豆知識に投票しました');
    }

    private function update_trivia_vote($id, $vote)
    {
        DB::beginTransaction();
        try{
            $trivia = Trivia::where('id', $id)->first();
            $trivia->$vote ++;
            $trivia->save();

            $this->update_vote_user_status($id, $vote);
            DB::commit();
        } catch (\PDOException $e){
            DB::rollBack();
        }
    }

    private function update_vote_user_status($id, $vote)
    {   
        $user_id = \Auth::user()->id;
        $vote_user_status = VoteUserStatus::where('user_id',$user_id)->where('trivia_id', $id)->first();
        if(empty($vote_user_status)){
            $vote_user_status = new VoteUserStatus();
            $vote_user_status->trivia_id = $id;
            $vote_user_status->user_id = $user_id;
        }
        if($vote === 'vote_up'){
            $vote_user_status->vote_up = !$vote_user_status->vote_up;
            $vote_user_status->vote_down = false;
        }else if($vote === 'vote_down'){
            $vote_user_status->vote_down = !$vote_user_status->vote_down;
            $vote_user_status->vote_up = false;
        }else{
            return back()->with('flash_message', '豆知識に投票しました');
        }
        
        $vote_user_status->save();
    }
}
