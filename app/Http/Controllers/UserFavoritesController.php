<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserFavoritesController extends Controller
{
    public function store(Request $request, $id)
    {
        \Auth::user()->addFav($id);
        return redirect()->back();
    }
    
    public function destroy($id)
    {
        \Auth::user()->delFav($id);
        return redirect()->back();
    }
}
