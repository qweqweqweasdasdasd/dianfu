<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    protected $primaryKey = 'u_id';
	
	protected $table = 'client';
	
    protected $fillable = [
    	'nikename','realname','tel','pingtai','regtime','loginlasttime','daili','http','c_money','t_money','status','order_li','desc'
    ];

    //物理删除导入的时候插入冲突

    //use SoftDeletes;
    //protected $dates 	  = ['deleted_at'];
}
