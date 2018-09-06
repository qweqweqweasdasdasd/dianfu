<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jobs extends Model
{
    protected $primaryKey = 'j_id';
	
	protected $table = 'jobs';
	
    protected $fillable = [
    	'u_id','mg_id','h_id'
    ];


    use SoftDeletes;
    protected $dates 	  = ['deleted_at'];

    //建立任务表和回访记录表一对多的关系
    public function visit()
    {
    	return $this->hasMany('App\Visit','j_id','j_id');
    }

    //任务表和客户表是一对一的关系
    public function client()
    {
    	return $this->hasOne('App\Client','u_id','u_id');
    }

}
