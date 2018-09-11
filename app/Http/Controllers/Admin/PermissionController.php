<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Repositories\PermissonRepository;
use App\Http\Requests\StorePermissionRequest;

class PermissionController extends Controller
{
  	//私有属性
  	protected $permissionRepository;

  	//构造函数	
  	public function __construct(PermissonRepository $permissionRepository)
  	{
  		$this->permissionRepository = $permissionRepository;
  	}
	
    //显示权限列表
    public function index()
    {
      if(!$tree = Cache::get('permission')){

    	   $tree = $this->permissionRepository->getPermissionTree();
         Cache::store('file')->put('permission',$tree,10);
      };
      
    	return view('admin.permission.index',compact('tree'));
    }

    //显示添加权限
    public function create()
    {
    	$tree = $this->permissionRepository->getPermissionTree();

    	return view('admin.permission.create',compact('tree'));
    }

    //保存权限数据
   	public function store(StorePermissionRequest $request)
   	{
   		$z = $this->permissionRepository->storePermissionDataToDb($request->all());
   		
   		return $z ? ['code'=>'1'] : ['code'=>0];
   	}

   	//显示编辑权限页面
   	public function show(Request $request,$id)
   	{
   		$tree = $this->permissionRepository->getPermissionTree();
   		$info = $this->permissionRepository->getPermissionById($id);

   		return view('admin.permission.show',compact('tree','info'));
   	}

   	//保存编辑权限
   	public function save(Request $request)
   	{
   		$this->permissionRepository->updatePermissionDataToDb($request->all());

   		return ['code'=>1];
   	}

   	//删除权限
   	public function del(Request $request)
   	{
   		$z = $this->permissionRepository->deletePermissionById($request->get('id'));

   		return $z ? ['code'=>1] : ['code'=>0,'error'=>'此权限是父级权限请先删除子权限'];
   	}

}
