<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visit extends Model
{
    protected $primaryKey = 'v_id';
	
	protected $table = 'visit';
	
    protected $fillable = [
    	'title','content','j_id','is_yuehui'
    ];


    use SoftDeletes;
    protected $dates 	  = ['deleted_at'];

    //回访信息
    public function jobs()
    {
    	return $this->hasOne('App\Jobs','j_id','j_id');
    }

}
