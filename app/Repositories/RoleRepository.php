<?php 
namespace App\Repositories;

use App\Role;
use App\Permission;

class RoleRepository 
{
	//获取到角色的信息
	public function getRoleData()
	{
		return Role::get();
	}	

	//通过id删除角色
	public function delRoelById($id)
	{
		return Role::where('r_id',$id)->delete();
	}	

	//创建新用户组
	public function storeRole($d)
	{
		return Role::create($d);
	}

	//通id获取到一条数据
	public function getRoelInfoById($id)
	{
		return Role::find($id);
	}

	//获取到权限 a b c
	public function getPermissionInfo($level)
	{
		return Permission::where('ps_level',$level)->get();
	}

	//处理数据之后保存到数据内
	public function saveQxToDb($d)
	{
		$data = [];
		$data['ps_ids'] = implode(',',$d['qx']);
		$ps_ca = Permission::whereIn('p_id',$d['qx'])
					->select(\DB::raw("concat (ps_c,'-',ps_a) as ca"))
					->whereIn('ps_level',[1,2])
					->pluck('ca');
		$data['ps_ca'] = implode(',', $ps_ca->toArray());			
		
		return Role::where('r_id',$d['r_id'])->update($data);
	}

	//获取到角色名和id 
	public function getRoleAndId()
	{
		return Role::pluck('r_name','r_id');
	}

}
?>
