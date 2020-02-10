<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CreateGenre;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    //adminステータスがtrueの場合のみ管理者ページを表示する
    public function show_admin()
    {
        $users = $this->get_users();
        $genre = $this->get_all_genre();
        $user = \Auth::user()->admin;
        $users = $this->get_users();
        if($user == 0){
            return redirect('/')->with('flash_error', '不正なアクセスです');
        }
        return view('admin.admin',[
            'title' => '管理画面',
            'genre' => $genre,
            'users' => $users,
        ]);
    }

    private function get_users()
    {
        $users = User::all();
        return $users;
    }
    private function get_all_genre()
    {
        $get_all_genre = CreateGenre::all();
        return $get_all_genre;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
}
