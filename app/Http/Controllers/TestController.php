<?php

namespace App\Http\Controllers;

use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use App\LectureCategory;
use App\Test;
use App\Http\Requests\TestRequest;


class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('admin.tests.index', ['backToFront' =>
            ['categories' => LectureCategory::all()]
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tests.create', ['data' => [
            'categories' => LectureCategory::all()
        ]]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(TestRequest $request)
    {
        $test = Test::create($request->all());
        $test->load('questions.answers');
        return $test;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.tests.create', ['data' => [
            'categories' => LectureCategory::all(),
            'test' => Test::with('testable', 'questions.answers')->findOrFail($id)
        ]]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(TestRequest $request, $id)
    {

        $test = Test::findOrFail($id);

        $test->fill($request->all());

        $test->save();

        return $test->load('questions.answers', 'testable');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function search(Request $request){

        $titleField = $request->title_field;
        $createdField = $request->created_at_field;
        $categoryField = $request->category_field;

        return Test::with('testable', 'questions')
            ->when($titleField, function($query) use ($titleField){
                return $query->where('title', 'LIKE', '%'.$titleField.'%');
            })
            ->when($createdField, function($query) use($createdField){
                $explodedCreated = explode(',',$createdField);
                switch(count($explodedCreated)){
                    case 2:
                        return $query->whereBetween('created_at', [$explodedCreated[0], $explodedCreated[1]]);
                    case 1:
                        return $query->where('created_at', '>=', $explodedCreated[0]);
                    default:
                        return false;
                }
            })
            ->when($categoryField, function($query) use ($categoryField){
                return $query->where('testable_id', $categoryField)
                    ->where('testable_type', 'App\\LectureCategory');
            })
            ->paginate(15);
    }

    public function startTest($request, $test_key = 'not_key'){

        $begin = BeginTest::where('test_key', $test_key)
            ->where('user_id', $request->user()->id)->with('test')->firstOrFail();

        if(!$begin->result_count){
            return view('home.beginTest', ['test' => $test]);
        }

        $test = Test::where('test_key', $test_key)->first();

    }
}
