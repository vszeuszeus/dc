<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    protected $guarded = [];

    public function category(){
        return $this->belongsTo('App\LectureCategory', 'lecture_category_id');
    }

    public function tests(){
        return $this->morphMany('App\Test', 'testable');
    }

}
