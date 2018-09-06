<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Whitelist extends Model
{
    protected $primaryKey = 'w_id';
	
	protected $table = 'whitelist';
	
    protected $fillable = [
    	'ip_addr','mg_id'
    ];


    use SoftDeletes;
    protected $dates 	  = ['deleted_at'];
}
