<?php

namespace App\Http\Controllers;

use App\LectureCategory;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use App\Lecture;
use App\Test;
use App\TestBegin;

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
        $categories = LectureCategory::with('lectures', 'tests')->paginate(15);
        return view('home', ['categories' => $categories]);
    }

    public function readLecture($id){

        $lecture = Lecture::with('tests')->findOrFail($id);
        return view('home.readLecture', ['lecture' => $lecture]);

    }

    public function beginTest($type = 'lecture', $id, $request){

        $query_type = ($type === 'lecture') ? 'App\Lecture' : 'App\LectureCategory';

        $test = Test::where('testable_type', $query_type)
            ->where('testable_id', $id)->firstOrFail();

        $begin = TestBegin::create([
            'test_id' => $test->id,
            'user_id' => $request->user()->id,
            'test_key' => str_random(128)
        ]);

        return redirect('tests.begin', $begin->test_key);

    }

    public function getCertificate($id){

        return view('home.getCertificate');

    }

    public function testResult(){

        return view('home.testResult');

    }

}
