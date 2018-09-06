<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ManagerRepository;
use App\Repositories\PermissonRepository;

class IndexController extends Controller
{
	//私有属性
    protected $permissionRepository;
	protected $managerRepository;

	//构造函数	
	public function __construct(PermissonRepository $permissionRepository,ManagerRepository $managerRepository)
	{
        $this->permissionRepository = $permissionRepository;
		$this->managerRepository = $managerRepository;
	}
	
    //显示后台主页
    public function index(Request $request)
    {
        $mg_id = \Auth::guard('back')->user()->mg_id;
        try {      
            $ps_ids = $this->permissionRepository->getRolePs_idsById($mg_id);
            $permissoin_0 = $this->permissionRepository->getPermissionInfo($ps_ids);
            $permissoin_1 = $this->permissionRepository->getPermissionInfo($ps_ids,'1');
    
        } catch (\Exception $e) {
            if($mg_id == 1){
                $permissoin_0 = $this->permissionRepository->getPermissionRootInfo('root');
                $permissoin_1 = $this->permissionRepository->getPermissionRootInfo('root','1');
            }else{
                $permissoin_0 = [];  
                $permissoin_1 = [];  
            }
        }

    	return view('admin.index.index',compact('permissoin_0','permissoin_1'));
    }

    //显示welcome
    public function welcome()
    {
    	return view('admin.index.welcome');
    }

    //密码修改
    public function password(Request $request)
    {
        if($request->isMethod('post')){
            if(!$this->managerRepository->HashManager($request->all())){
                return ['code'=>0,'error'=>'初始密码不对'];
            };
            $this->managerRepository->updateManagerpassWord($request->get('newpwd'));
            return ['code'=>1];
        }
        return view('admin.index.password');
    }
}
