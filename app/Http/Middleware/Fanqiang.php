<?php

namespace App\Http\Middleware;

use Closure;
use App\Roel;
use App\Manager;

class Fanqiang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //获取当前登录的用户 mg_id
        $mg_id = \Auth::guard('back')->user()->mg_id;

        if($mg_id != 1){
            //获取到角色里面的 ps_ca 
            $ps_ca = Manager::find($mg_id)->role->ps_ca;

            $now = strtolower(getCurrentControllerName() . '-' . getCurrentMethodName());
            if(strpos($ps_ca,$now) === false){
                exit('没有权限!');
            }
        }

        return $next($request);
    }
}
