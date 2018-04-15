<?php

namespace App\Http\Controllers;

use App\LectureCategory;
use App\Lecture;
use Illuminate\Http\Request;
use App\Http\Requests\LectureRequest;

class LectureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.lecture.index', ['backToFront' =>
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
        return view('admin.lecture.create', ['categories' => LectureCategory::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LectureRequest $request)
    {

        $lecture = Lecture::create($request->all());

        return  redirect()->to(route('lectures.show', $lecture->id))->with('status', 'Лекция добавлена');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return  view('admin.lecture.show', ['lecture' => Lecture::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.lecture.edit', [
            'lecture' => Lecture::findOrFail($id),
            'categories' => LectureCategory::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LectureRequest $request, $id)
    {

        $lecture = Lecture::findOrFail($id);

        $lecture->fill($request->all());

        $lecture->save();

        return redirect()->to(route('lectures.show', $id))->with('status', 'Лекция отредактрована');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyWeb($id)
    {
        $lecture = Lecture::findOrFail($id);
        $lecture->delete();
        return redirect()->to(route('lectures.index'))->with('status', 'Лекция удалена');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lecture = Lecture::findOrFail($id);
        $lecture->delete();
        return json_encode(['deleted' => $id]);
    }

    public function search(Request $request){

        $titleField = $request->title_field;
        $createdField = $request->created_at_field;
        $categoryField = $request->category_field;

        return Lecture::with('category')
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
                return $query->where('lecture_category_id', $categoryField);
            })
            ->paginate(15);
    }

}
