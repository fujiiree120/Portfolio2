<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trivia;
use App\VoteUserStatus;
use App\UserRank;
use DB;
class VoteController extends Controller
{
    //public function

    public function __construct()
    {
        $this->middleware('auth');
    }

    //投票のvalueが正しい値かチェック→正しければ投票結果更新処理へ
    public function is_valid_trivia_vote(Request $request)
    {
        if($request->vote === "へー:"){
            $vote = 'vote_up';
            $vote_reverse = 'vote_down';
        }else if($request->vote === "う～ん"){
            $vote = 'vote_down';
            $vote_reverse = 'vote_up';
        }else{
            return redirect('/')->with('flash_error', '値が不正です');
        }
        $this->update_trivia($request->id, $vote, $vote_reverse, $request->user_id);
        return back()->with('flash_message', '雑学を投票しました');
    }


    //private function

    //is_valicd_trivia_voteが正しければ投票結果を更新する処理をする
    private function update_trivia($id, $vote, $vote_reverse, $user_rank_id)
    {
        DB::beginTransaction();
        try{
            $user_id = \Auth::user()->id;
            $vote_user_status = VoteUserStatus::where('user_id',$user_id)->where('trivia_id', $id)->first();    
            $this->update_trivia_vote($id, $vote_user_status, $vote, $vote_reverse, $user_rank_id);
            $this->update_vote_user_status($id, $vote, $vote_user_status, $user_id);
            DB::commit();
        } catch (\PDOException $e){
            DB::rollBack();
        }
    }

    //トリビアDBに投票結果を更新する(update_trivia内で実行)
    private function update_trivia_vote($id, $vote_user_status, $vote, $vote_reverse, $user_rank_id)
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
            $vote_true = false;
            $vote_false = false;
            $trivia->$vote ++;
        }
        $trivia->save();
        $this->update_user_rank($user_rank_id, $vote_true, $vote_false, $vote);
    }

    //投票結果をユーザーランキングDBに反映させる(update_trivia内で実行)
    private function update_user_rank($user_rank_id, $vote_true, $vote_false, $vote)
    {
        $user_rank = UserRank::where('user_id', $user_rank_id)->first();
        if(empty($user_rank)){
            $user_rank = new UserRank();
            $user_rank->user_id = $user_rank_id;
            $user_rank->user_score = 0;
        }
        if($vote_true == true && $vote === 'vote_up'){
            $user_rank->user_score --;
        }else if($vote_true == true && $vote === 'vote_down'){
            $user_rank->user_score ++;
        }else if($vote_false == true && $vote === 'vote_up'){
            $user_rank->user_score += 2;
        }else if($vote_false == true && $vote === 'vote_down'){
            $user_rank->user_score -= 2;
        }else if($vote === 'vote_up'){
            $user_rank->user_score ++;
        }else if($vote === 'vote_down'){
            $user_rank->user_score --;
        }
        $user_rank->save();
    }

    //投票したユーザーの投票結果ステータスを反映させる(update_trivia内で実行)
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
            return back()->with('flash_message', '雑学を投票しました');
        }     
        $vote_user_status->save();
    }
}
