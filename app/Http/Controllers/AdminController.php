<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //
    public function index(){
        if(Auth::user()->role == 'admin'){
            return view('admin.index');
        }
        return redirect()->back();
    }
}
