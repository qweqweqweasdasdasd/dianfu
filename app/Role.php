<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    protected $primaryKey = 'r_id';
	
	protected $table = 'role';
	
    protected $fillable = [
    	'r_name','ps_ids','ps_ca'
    ];


    use SoftDeletes;
    protected $dates 	  = ['deleted_at'];

    public function manager(){
    	return $this->hasMany('App\Manager','role_id','r_id');
    }
}
