<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fenpei extends Model
{
    protected $primaryKey = 'f_id';
	
	protected $table = 'fenpei';
	
    protected $fillable = [
    	'title','r_id','sum','status','desc'
    ];


    use SoftDeletes;
    protected $dates 	  = ['deleted_at'];

    //一对一关系
    public function role()
    {
    	return $this->hasOne('App\Role','r_id','r_id');
    }
}
