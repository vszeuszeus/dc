<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestBegin extends Model
{

    protected $guarded = [];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function test(){
        return $this->belongsTo('App\Test');
    }
}
