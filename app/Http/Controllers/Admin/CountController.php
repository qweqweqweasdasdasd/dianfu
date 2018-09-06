<?php

namespace App\Http\Controllers\Admin;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountController extends Controller
{
    //显示统计的页面
    public function index()
    {
    	return view('admin.count.index');
    }

    //统计月份
    public function month(Request $request)
    {
    	$month = substr($request->get('month'),0,2);

        $data = DB::table('count')
                        ->select(\DB::raw('count(count_id) as count,mg_id'))
                        ->whereMonth('created_at', $month)
                        ->groupBy('count.mg_id')
                        ->get();
        $newData = [];
        foreach ($data as $k=>$v) {
            $newData[$k]['count'] = $v->count; 
            $newData[$k]['mg_id'] = $v->mg_id; 
            $newData[$k]['month'] = $month; 
            $newData[$k]['mg_name'] = DB::table('manager')->where('mg_id',$v->mg_id)->value('mg_name'); 
        }

        $h = $this->createTrHtml($newData);   
        return $h ? ['code'=>1,'error'=>$h]:['code'=>0,'error'=>'没有数据'];
    }

    //月内查询
    public function info(Request $request)
    {
        $month = $request->route('month');
        $mg_id = $request->route('mg_id');
        $data = DB::table('count')->where('mg_id',$mg_id)->whereMonth('created_at',$month)->get();
        $manager = DB::table('manager')->pluck('mg_name','mg_id');

        return view('admin.count.info',compact('data','manager'));
    }

    //生成html
    public function createTrHtml($newData)
    {
        $html = '';
        foreach ($newData as $k => $v) {
            $html .= '<tr><td>'.$v['mg_name'].'</td>';
            $html .= '<td>'.$v['count'].'</td>';
            $html .= '<td id="check" month="'.$v['month'].'" mg-id="'.$v['mg_id'].'"><span style="color: #f00">查看当月</span></td></tr>';
        }

        return $html;
    }
}
