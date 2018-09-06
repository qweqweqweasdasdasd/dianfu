<?php 
namespace App\Repositories;

use DB;
use App\Jobs;
use App\Fenpei;
use App\Client;

class FenpeiRepository 
{
	//添加分配工作保存
	public function storeFenpeiDataToDB(array $d)
	{
		if(!$this->is_fenpeiSameRole($d)){	//无规则
			return Fenpei::create($d);
		};
		return false;
	}

	//是否有相同组启用不同的分配规则
	public function is_fenpeiSameRole($d)
	{		
		//判断规则是否是本身
		$f_post = $d['f_id'];
		$f_db = Fenpei::where([
					['status',1],['r_id',$d['r_id']]
				])->first();
	
		//没有开启的角色
		if(!Fenpei::where([['status','1'],['r_id',$d['r_id']]])->first()){
			return false;	
		}
		if($f_post == $f_db->f_id){	//相同一个角色
			return false;
		}
		return true;
	}

	//获取到所有的规则
	public function getFenpeiData($kk)
	{
		return Fenpei::leftJoin('role','fenpei.r_id','role.r_id')
						->where(function($query) use($kk){
							if(!empty($kk)){
								$query->where('sum',$kk)
									  ->orWhere('role.r_name',$kk);
							}
						})
						->orderBy('f_id','asc')
						->paginate(9);
	}

	//删除分配
	public function deleteFenpeiById($f_id)
	{
		//停用的状态
		if(!$this->checkStatusById($f_id)){
			return Fenpei::where('f_id',$f_id)->delete();
		};
		return false;
	}

	//检查当前的状态
	public function checkStatusById($f_id)
	{
		return Fenpei::where('f_id',$f_id)->value('status');
	}

	//通过id获取一条数据
	public function getInfoById($f_id)
	{
		return Fenpei::find($f_id);
	}

	//通过id更新数据
	public function updateFenpeiById(array $d)
	{
		//相同组启用不同的分配规则
		if($d['status'] == '1' && !$this->is_fenpeiSameRole($d)){	//设置为开启 ,, 无规则
			return Fenpei::where('f_id',$d['f_id'])->update(array_except($d,['f_id']));
		}else if($d['status'] != '1'){								//设置为关闭
			return Fenpei::where('f_id',$d['f_id'])->update(array_except($d,['f_id']));
		}
		return false;
	}


	//获取到分配工作表所有激活的数据
	public function getFenpeiStatusDataTrue()
	{
		return Fenpei::where('status',true)->get();
	}

	//组装插入任务表的数据
	public function insertJobsData($d)
	{
		foreach($d as $v){
				$sum = $v->sum;
			foreach($v->role->manager as $manager){
				$this->insertJobsToData($sum,$manager->mg_id);
			}
		}
		return '1';
	}

	//循环插入数据
	public function insertJobsToData($sum,$mg_id)
	{
		try {
			for ($i=0; $i < $sum; $i++) { 
				$u_id = Client::where('status','0')->first()->u_id;    // u_id  mg_id  h_id 
				Jobs::create(['u_id'=>$u_id,'mg_id'=>$mg_id]);
				Client::where('u_id',$u_id)->update(['status'=>'1']);	// 1 待处理
			}
		} catch (\Exception $e) {
			
		}
		//记录标准数量 和 分配对象 和创建时间 00:00
		DB::table('count')->insert(['f_sum'=>$sum,'mg_id'=>$mg_id,'created_at'=>date('Y-m-d H:i:s',time())]);
		return '1';
	}

}
?>
