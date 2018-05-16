<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LectureCategory;
use App\Test;
use App\Http\Requests\TestRequest;
use App\TestBegin;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TestCheckRequest;


class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->authorize('index', new Test());
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
        $this->authorize('create', new Test());
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
        $this->authorize('store', new Test());
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
        $this->authorize('edit', new Test());
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

        $this->authorize('update', new Test());

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
        return json_encode(['result' => Test::findOrFail($id)->delete()]);
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

    public function begin($test_key = 'not_key'){

        $begin = TestBegin::where('test_key', $test_key)
            ->where('user_id', Auth::user()->id)->firstOrFail();

        if(!$begin->result_count){
            $begin->load('test.questions.answers', 'test.testable');
            return view('home.beginTest', ['begin' => $begin]);
        }else{
            $begin->load('test.testable');
            return view('home.testResult', ['begin' => $begin]);
        }

    }

    public function check(TestCheckRequest $request){

        $test = Test::with('questions.answers')->findOrFail($request->test_id);

        $trueAnswers = 0;

        foreach($request->answers as $key=>$answerR){
            foreach ($test->questions as $question):
                if( $key == $question->id ){
                    foreach($question->answers as $answer):
                        if($answerR == $answer->id){

                           if($answer->trusted){
                               $trueAnswers++;
                           }

                        }
                    endforeach;
                }
            endforeach;
        }

        $begin = TestBegin::where('test_key', $request->test_key)->first();
        if(!$begin->result_count){
            $begin->result_count = $trueAnswers;
            $begin->questions_count = $test->questions->count();
            $begin->save();
        }
        return redirect()->route('tests.begin',$begin->test_key);

    }
}
