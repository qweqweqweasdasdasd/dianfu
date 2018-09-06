<?php 
namespace App\Repositories;

use DB;
use App\Manager;
use App\Whitelist;

class WhitelistRepository 
{
	//获取到白名单列表
	public function getWhitelist()
	{
		return Whitelist::get();
	}

	//保存白名单
	public function storeWhitelist($str)
	{
		$arr = explode(',',rtrim($str,','));
		$time = date('Y-m-d H:i:s',time());
		foreach($arr as $v){
			DB::table('whitelist')->insert(['ip_addr'=>$v,'mg_id'=>get_mg_id(),'created_at'=>$time]);
		}
		return true;
	}

	//删除白名单
	public function deletewhitelist($id)
	{
		return Whitelist::where('w_id',$id)->delete();
	}

	//获取到管理员姓名和下表
	public function getMgNameIndex()
	{
		return Manager::pluck('mg_name','mg_id');
	}
}
?>
