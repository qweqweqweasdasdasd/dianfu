<?php

namespace App\Http\Controllers\Admin;

use Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RedisController extends Controller
{
    //测试redis
    public function index()
    {
    	$value = Cache::store('memcached')->get('foo');
    	dd($value);
    }
}
