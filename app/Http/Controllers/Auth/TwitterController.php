<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Abraham\TwitterOAuth\TwitterOAuth;
use App\User;
use Auth;
use Illuminate\Support\Facades\Storage;
class TwitterController extends Controller
{
    //

    public function socialLogin($social)
    {
        return Socialite::driver($social)->redirect();
    }

    //Callback処理
    public function handleProviderCallback()
    {
        $social = "twitter";
        try {
            $userSocial = Socialite::driver($social)->user();
        } catch (Exception $e) {
            return redirect()->route('/')->withErrors('ユーザー情報の取得に失敗しました。');
        }
        $user = User::where(['email' => $userSocial->getEmail()])->first();

        if($user){
            if($user->twitter_id  !== $userSocial->getNickname()){
                $user->twitter_id = $userSocial->getNickname();
                $user->save();
            }
            
            //ログインしてトップページにリダイレクト
            Auth::login($user);
            return redirect('/');
        }else{
            $newuser = new User;
            $newuser->name = $userSocial->getName();
            $newuser->email = $userSocial->getEmail();
            $newuser->twitter_id = $userSocial->getNickname();
            
            $img = file_get_contents($userSocial->avatar_original);
            if ($img !== false) {
                $file_name = $userSocial->id . '_' . uniqid() . '.jpg';
                Storage::put('public/profile_images/' . $file_name, $img);
                $newuser->avatar = $file_name;
            }
            //ユーザ作成     
            $newuser->save();
            //ログインしてトップページにリダイレクト
            Auth::login($newuser);
            return redirect('/');
        }
        
    }
}
