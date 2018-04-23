<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListerRequest;
use Illuminate\Http\Request;
use App\LectureCategory;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('create', new LectureCategory());
        return view('admin.lister.index', ['data' => [
            'listData' => LectureCategory::all(),
            'model' => 'categories',
            'name' => 'Категории лекций'
        ]]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ListerRequest $request)
    {

        $model = LectureCategory::create($request->all());

        return json_encode($model);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ListerRequest $request, $id)
    {

        $model = LectureCategory::findOrFail($id);
        $model->title = $request->title;
        $model->save();

        return json_encode($model);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = LectureCategory::findOrFail($id);
        $model->delete();
        return json_encode(['deleted' => $id]);
    }
}
