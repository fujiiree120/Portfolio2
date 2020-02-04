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
            $vote_reverse = 'vote_down';
        }else if($request->vote === "ちがうよ:"){
            $vote = 'vote_down';
            $vote_reverse = 'vote_up';
        }else{
            return redirect('/')->with('flash_error', '値が不正です');
        }

        $this->update_trivia($request->id, $vote, $vote_reverse);
        return back()->with('flash_message', '豆知識に投票しました');
    }

    private function update_trivia($id, $vote, $vote_reverse)
    {
        DB::beginTransaction();
        try{
            $user_id = \Auth::user()->id;
            $vote_user_status = VoteUserStatus::where('user_id',$user_id)->where('trivia_id', $id)->first();    

            $this->update_trivia_vote($id, $vote_user_status, $vote, $vote_reverse);
            $this->update_vote_user_status($id, $vote, $vote_user_status, $user_id);
            DB::commit();
        } catch (\PDOException $e){
            DB::rollBack();
        }
    }

    private function update_trivia_vote($id, $vote_user_status, $vote, $vote_reverse)
    {
        $trivia = Trivia::where('id', $id)->first();
        if(!empty($vote_user_status)){
            $vote_true = $vote_user_status->$vote;
            $vote_false = $vote_user_status->$vote_reverse;

            if($id == $vote_user_status->trivia_id && $vote_true == true){
                $trivia->$vote --;
            }else if($id == $vote_user_status->trivia_id && $vote_true == false && $vote_false == true){
                $trivia->$vote ++;    
                $trivia->$vote_reverse --;
            }else{
                $trivia->$vote ++;
            }
        }else{
            $trivia->$vote ++;
        }
        $trivia->save();
    }

    private function update_vote_user_status($id, $vote, $vote_user_status, $user_id)
    {   
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
