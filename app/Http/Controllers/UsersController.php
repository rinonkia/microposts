<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User; //追加

class UsersController extends Controller
{
    
    //ユーザー一覧
    public function index()
    {
        $users = User::paginate(1);
        
        return view('users.index', [
            'users' => $users,
            ]);
    }
    
    //ユーザー詳細
    public function show($id) 
    {
        $user = User::find($id);
        
        return view('users.show', [
            'user' => $user,
            ]);
    }
}
