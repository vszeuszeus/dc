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

    public function checkResult(){
        if($this->result_count){
            return (($this->result_count * 100) / $this->questions_count >= 70);
        }else{
            return false;
        }

    }
}
