<?php 
namespace App\Repositories;

use App\Client; 

class ClientRepository 
{
	//获取到客户的信息
	public function getClientData($keyword)
	{
		return Client::select('u_id','nikename','realname','tel','pingtai','c_money','t_money','status','created_at')
					->where(function($query) use($keyword){
						if(!empty($keyword)){
							$query->where('nikename',$keyword)
							      ->orWhere('tel',$keyword)
							      ->orWhere('pingtai',$keyword);
						}
					})
					->orderBy('u_id','desc')
					->paginate(11);
	}

	//获取到客户的数量
	public function countClient()
	{
		return Client::count();
	}

	//通过id获取客户信息
	public function getInfoById($u_id)
	{
		return Client::where('u_id',$u_id)->first();
	}

	//更新数据
	public function storeClientToData($d)
	{
		$data = array_except($d,['u_id']);
		
		return Client::where('u_id',$d['u_id'])->update($data);
	}
}
?>
