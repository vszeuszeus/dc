<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lecture;
use App\Test;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function readLecture($id){

        $lecture = Lecture::with('tests')->findOrFail($id);
        return view('home.readLecture', ['lecture' => $lecture]);

    }

    public function beginTest($id){

        //$test = Test::with('questions.answers', 'testable')->findOrFail($id);
        return view('home.beginTest');//, ['test' => $test]);

    }
}
