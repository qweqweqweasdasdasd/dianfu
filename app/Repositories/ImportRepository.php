<?php 
namespace App\Repositories;

use App\Manager;
use App\Import;
use App\Client;
use App\Visit;

class ImportRepository 
{
	//获取到导入历史记录
	public function getimportData($k)
	{
		return Import::select('import.*','manager.mg_name')
						->leftJoin('manager','import.mg_id','manager.mg_id')
						->where(function($query) use($k){
							if(!empty($k)){
								$query->where('order_li',$k)
									  ->orWhere('mg_name',$k);
							}
						})
						->paginate(11);
	}

	//管理员id和管理名称
	public function getManager_name_id()
	{
		return Manager::pluck('mg_name','mg_id');
	}

	//通过单号进行删除用户信息物理删除的
	public function deleteClientByorderLi($order_li)
	{
		$this->deleteImport($order_li);	//删除单号记录
		return Client::where('order_li',$order_li)->delete();
	}
	
	//删除单号记录
	public function deleteImport($order_li)
	{
		return Import::where('order_li',$order_li)->delete();
	}

	//获取到需要的数据
	public function getExportData($data)
	{
		$d = explode('至',$data);
		$min = trim($d[0]);
		$max = trim($d[1]);
		$data = [];
		$visit = Visit::whereBetween('created_at',[$min,$max])->get();
		$manager = $this->getManager_name_id();

		foreach ($visit as $v) {
			$data[$v->v_id]['v_id'] = $v->v_id;
			$data[$v->v_id]['title'] = $v->title;
			$data[$v->v_id]['content'] = $v->content;
			$data[$v->v_id]['created_at'] = $v->created_at;
			$data[$v->v_id]['nikename'] = $v->jobs->client->nikename;
			$data[$v->v_id]['realname'] = $v->jobs->client->realname;
			$data[$v->v_id]['pingtai'] = $v->jobs->client->pingtai;
			$data[$v->v_id]['mg_name'] = $manager[$v->jobs->mg_id];
		}
		return $data;
	}
}
?>
