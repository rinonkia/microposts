<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User; //追加

class UsersController extends Controller
{
    
    //ユーザー一覧
    public function index()
    {
        $users = User::paginate(10);
        
        return view('users.index', [
            'users' => $users,
            ]);
    }
    
    //ユーザー詳細
    public function show($id) 
    {
        $user = User::find($id);
        $microposts = $user->microposts()->orderBy('created_at', 'desc')->paginate(10);
        
        $data = [
            'user' => $user,
            'microposts' => $microposts,
        ];
        
        $data += $this->counts($user);

        return view('users.show', $data);
    }
    
    public function followings($id)
    {
        $user = User::find($id);
        $followings = $user->followings()->paginate(10);
        
        $data = [
            'user' => $user,
            'users' => $followings,
        ];
            
            $data += $this->counts($user);
            
        return view('users.followings', $data);
    }
    
    public function followers($id)
    {
        $user = User::find($id);
        $followers = $user->followers()->paginate(10);
        
        $data = [
            'user' => $user,
            'users' => $followers,
        ];
        
        $data += $this->counts($user);
        
        return view('users.followers', $data);
        
    }
    
    public function favorites($id)
    {
        $user = User::find($id);
        $favor = $user->favorite()->paginate(10);
        
        $data = [
            'user' => $user,
            'favMicroposts' => $favor,
        ];
        
        $data += $this->counts($user);
        
        return view('users.favorites', $data);
    }
}
