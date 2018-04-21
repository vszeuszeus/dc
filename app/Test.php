<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $guarded = [];

    public function testable(){
        return $this->morphTo();
    }

    public function questions(){
        return $this->hasMany('App\Question');
    }

    public function begins(){
        return $this->hasMany('App\BeginTest', 'test_id');
    }

}
