<?php 

namespace App\Repositories;

use App\Manager;
use App\Permission;


class PermissonRepository 
{
	//获取到当前用户的权限信息
	public function getPermissionInfo(array $arr,$level=0)
	{
		
		return Permission::where('ps_level',$level)->whereIn('p_id',$arr)->get();
	}

	//获取到当前用户的 ps-ids 信息
	public function getRolePs_idsById($mg_id)
	{
		$str = Manager::where('mg_id',$mg_id)->first()->role->ps_ids;
		return explode(',', $str);
	}

	//获取到 root 权限
	public function getPermissionRootInfo($root,$level=0)
	{
		return Permission::where('ps_level',$level)->get();
	}

	//获取权限数据树
	public function getPermissionTree()
	{
		return generateTree(Permission::get()->toArray());
	}

	//保存权限
	public function storePermissionDataToDb(array $d)
	{
		if($d['ps_pid'] != 0){
			$pid_level = Permission::where('p_id',$d['ps_pid'])->value('ps_level');
			$d['ps_level'] = (string)($pid_level + 1);
		}else{
			$d['ps_level'] = 0;
		}
		return Permission::create($d);
	}

	//获取到一条数据
	public function getPermissionById($id)
	{
		return Permission::find($id);
	}

	//更新一条数据
	public function updatePermissionDataToDb(array $d)
	{
		if($d['ps_pid'] != 0){
			$pid_level = Permission::where('p_id',$d['ps_pid'])->value('ps_level');
			$d['ps_level'] = (string)($pid_level + 1);
		}else{
			$d['ps_level'] = 0;
		}
		return Permission::where('p_id',$d['p_id'])->update(array_except($d,['p_id']));
	}

	//删除权限
	public function deletePermissionById($id)
	{
		if(!Permission::where('ps_pid',$id)->count()){
			return Permission::where('p_id',$id)->delete();
		};
		return false;
	}
}

?>