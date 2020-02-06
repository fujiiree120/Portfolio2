<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function show_admin()
    {
        $user = \Auth::user()->admin;
        if($user == 0){
            return redirect('/')->with('flash_error', '不正なアクセスです');
        }
        return view('admin.admin',[
            'title' => '管理画面',
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
}
