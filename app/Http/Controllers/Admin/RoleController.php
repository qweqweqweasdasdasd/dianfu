<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Repositories\RoleRepository;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
	//私有属性
	protected $roleRepository;

	//构造函数	
	public function __construct(RoleRepository $roleRepository)
	{
		$this->roleRepository = $roleRepository;
	}

    //角色列表
    public function index()
    {
    	$info = $this->roleRepository->getRoleData();
        
    	return view('admin.role.index',compact('info'));
    }

    //删除角色
    public function del(Request $request)
    {
    	$z = $this->roleRepository->delRoelById($request->get('id'));
    
    	return $z ? ['code'=>1] : ['code'=>0];
    }

    //添加用户组
    public function create()
    {
    	return view('admin.role.create');
    }

    //添加保存
    public function store(Request $request)
    {
    	return $this->roleRepository->storeRole($request->all())?['code'=>1]:['code'=>0];
    }

    //显示权限页面
    public function qxview($r_id)
    {
        $info = $this->roleRepository->getRoelInfoById($r_id);
        $permission_0 = $this->roleRepository->getPermissionInfo(0);
        $permission_1 = $this->roleRepository->getPermissionInfo(1);
        $permission_2 = $this->roleRepository->getPermissionInfo(2);    
        $ps_idsArr = explode(',', $info->toArray()['ps_ids']);

        return view('admin.role.qxview',compact('info','permission_0','permission_1','permission_2','ps_idsArr'));
    }

    //保存分配权限
    public function qxsave(Request $request)
    {
        //处理数据之后保存到数据内
        $z = $this->roleRepository->saveQxToDb($request->all());
        
        return $z ? ['code'=>1] : ['code'=>0];
    }
}
