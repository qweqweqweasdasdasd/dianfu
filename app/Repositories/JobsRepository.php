<?php 
namespace App\Repositories;

use DB;
use App\Jobs;
use App\Client;
use App\Visit;
use App\Manager;

class JobsRepository 
{
	//获取到所有的任务数据
	public function getjobsData()
	{
		return Jobs::select('j_id','client.nikename','jobs.status','client.u_id','jobs.mg_id')
						->leftJoin('client','jobs.u_id','client.u_id')
				 		->leftJoin('manager','jobs.mg_id','manager.mg_id')
						->where([
							['jobs.status','1'],
							['jobs.mg_id',get_mg_id()],
						 ])
						->orWhere([
							['jobs.status','2'],
							['jobs.mg_id',get_mg_id()],
						 ])
						->limit(10)
						->get();
	}


	//修改回访状态为 2
	public function setworkingstatus_2($j_id)
	{
		Jobs::where('j_id',$j_id)->update(['status'=>2]);
		$u_id = Jobs::where('j_id',$j_id)->value('u_id');

		return Client::where('u_id',$u_id)->update(['status'=>2]);
	}

	//获取到一条 job
	public function getJobInfo($j_id)
	{
		
		return Jobs::select('jobs.j_id','realname','tel','pingtai','regtime','loginlasttime','daili','http','c_money','t_money','jobs.u_id','jobs.mg_id')
					->leftJoin('client','jobs.u_id','client.u_id')
					->where('j_id',$j_id)
					->first();
	}

	//回访记录保存
	public function storeVisit($d)
	{
		Client::where('u_id',$d['u_id'])->update(['status'=>3]);	//3 为回访完毕
		Jobs::where('j_id',$d['j_id'])->update(['status'=>3]);
		return Visit::create(array_except($d,['u_id']));
	}

	//昨天没有完成的数量
	public function yesterdayJobsNook()	//当前用户 ,,, status 为 0 ,,  ?? 
	{
		if(is_root()){		//超级管理员显示所有的数据
			return Jobs::whereDate('created_at',date('Y-m-d',strtotime('-1 day')))
					->where('status',1)
					->count();
		}
		return Jobs::whereDate('created_at',date('Y-m-d',strtotime('-1 day')))
					->where([['mg_id',get_mg_id()],['status',1]])
					->count();
	}
	//今天的工作总量
	public function todayJobsCount()
	{
		if(is_root()){	//超级管理员显示所有的数据
			return Jobs::whereDate('created_at',date('Y-m-d',time()))
						->count();
		}
		return Jobs::whereDate('created_at',date('Y-m-d',time()))
						->where('mg_id',get_mg_id())
						->count();
	}
	//今天完成量
	public function todayJobsOk()	//当前用户 ,,, status 为 3 ,,  ??? 
	{
		if(is_root()){	//超级管理员显示所有的数据
			return Jobs::whereDate('created_at',date('Y-m-d',time()))
						->where('status',3)
						->count();
		}
		return Jobs::whereDate('created_at',date('Y-m-d',time()))
						->where([['mg_id',get_mg_id()],['status',3]])
						->count();
	}

	//属于某个人的回访总数
	public function countByMg()
	{
		return Jobs::where([['mg_id',get_mg_id()],['status',3]])
					 ->count();
	}

	//获取到自己回访记录信息
	public function getVisitData()
	{
		return Jobs::where([['mg_id',get_mg_id()],['status',3]])->paginate(11);
	}

	//根据任务id获取到相关的回访信息
	public function getvisitByu_id($u_id)
	{
		return Jobs::where('u_id',$u_id)->get();
	}

	//获取到管理名称和id
	public function mg_nameAndID()
	{
		return Manager::pluck('mg_name','mg_id');
	}

	//退回重新回访
	public function rollbackTosatus_0($j_id)
	{
		//修改任务表的状态为  0 
		Jobs::where('j_id',$j_id)->update(['status'=>4]);  // 不显示
		$u_id = Jobs::where('j_id',$j_id)->value('u_id');
		//修改客户表状态为 0
		return Client::where('u_id',$u_id)->update(['status'=>0]);
	}


	//自增长统计表回访字段的数量
	public function countIncrement()
	{
		return DB::table('count')
					->where('mg_id',get_mg_id())
					->whereDate('created_at',date('Y-m-d',time()))
					->increment('h_sum');
		
	}

	//写入数据库统计信息
	public function updateBymgidWithh_sum($value='')
	{	
		$arr = DB::table('count')->whereDate('created_at',date('Y-m-d',time()))->pluck('mg_id');

		foreach ($arr as $mg_id) {
			$count = Jobs::whereDate('created_at',date('Y-m-d',time()))
							->where([['mg_id',$mg_id],['status',3]])
							->count();
			DB::table('count')->where('mg_id',$mg_id)->whereDate('created_at',date('Y-m-d',time()))->update(['h_sum'=>$count]);
		}
		
		return 1;
	}
}
?>
