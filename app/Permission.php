<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    protected $primaryKey = 'p_id';
	
	protected $table = 'permission';
	
    protected $fillable = [
    	'p_name','ps_pid','ps_c','ps_a','ps_route','ps_level','icon'
    ];


    use SoftDeletes;
    protected $dates 	  = ['deleted_at'];
}
