<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Manager extends Authenticatable
{
    protected $primaryKey = 'mg_id';
	
	protected $table = 'manager';
	
    protected $fillable = [
    	'mg_name','password','role_id','sesstion_id','IP','last_login_time','status'
    ];


    use SoftDeletes;
    protected $dates 	  = ['deleted_at'];

    //一对一的关系
    public function role()
    {
    	return $this->hasOne('App\Role','r_id','role_id');
    }

}
