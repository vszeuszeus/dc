<?php

namespace App\Http\Controllers;

use App\LectureCategory;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use App\Lecture;
use App\Test;
use App\TestBegin;
use Illuminate\Support\Facades\Auth;

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
        $categories = LectureCategory::with(['lectures', 'tests','tests.begins' => function($q){
            $q->where('user_id', Auth::user()->id);
        }])->paginate(15);
        return view('home', ['categories' => $categories]);
    }

    public function readLecture($id){

        $lecture = Lecture::with('tests')->findOrFail($id);
        return view('home.readLecture', ['lecture' => $lecture]);

    }

    public function beginTest($type, $id){

        $query_type = ($type === 'lecture') ? 'App\Lecture' : 'App\LectureCategory';

        $test = Test::where('testable_type', $query_type)
            ->where('testable_id', $id)->firstOrFail();

        $begin = TestBegin::create([
            'test_id' => $test->id,
            'user_id' => Auth::user()->id,
            'test_key' => str_random(128)
        ]);

        return redirect()->route('tests.begin', $begin->test_key);

    }

    public function getCertificate($id){

        $category = LectureCategory::with(['tests', 'tests.begins' => function($q){
            $q->where('user_id', Auth::user()->id);
        }])->findOrFail($id);

        if($category->checkPassedTest()){
            return view('home.getCertificate');
        }else{
            return redirect()->back();
        }

    }

    public function testResult(){

        return view('home.testResult');

    }

}
