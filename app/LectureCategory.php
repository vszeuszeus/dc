<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LectureCategory extends Model
{
    protected $guarded = [];
    protected $table = 'lecture_categories';

    public function lectures(){
        return $this->hasMany('App\Lecture', 'lecture_category_id');
    }

    public function tests(){
        return $this->morphMany('App\Test', 'testable');
    }
}
