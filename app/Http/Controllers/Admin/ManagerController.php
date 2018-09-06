<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\RoleRepository;
use App\Repositories\ManagerRepository;
use App\Http\Requests\StoreLoginRequest;
use App\Http\Requests\StoreManagerRequest;

class ManagerController extends Controller
{
	//私有属性
    protected $managerRepository;
	protected $roelRepository;

	//构造函数
	public function __construct(ManagerRepository $managerRepository,RoleRepository $roelRepository){
        $this->managerRepository = $managerRepository;
		$this->roelRepository = $roelRepository;
	}
    //显示用户列表
    public function index(Request $request)
    {   
        if($request->isMethod('post')){
            error_reporting(0);
            $keyword = $request->input('keyword','');
           
            $data = $this->managerRepository->getManagerData($keyword,$request->all());
           
            $z = $this->managerRepository->jointManagerTableHtml($data);
            return $z ? ['code'=>1,'data'=>$z] : ['code'=>0];
        }

        $count = $this->managerRepository->getManagerCount();
        return view('admin.manager.index',compact('count'));
    }
    //删除管理员用户
    public function del(Request $request)
    {
        return $this->managerRepository->delManager($request->get('mg_id'))?['code'=>1]:['code'=>0];
    }

    //修改用户状态
    public function setstatus(Request $request)
    {
        $z = $this->managerRepository->setManagerStatus($request->get('mg_id'));
        return $z ? ['code'=>1] : ['code'=>0]; 
    }

    //显示登录页面
    public function login()
    {
    	return view('admin.manager.login');
    }

    //检查登录数据提交
    public function storemanager(StoreLoginRequest $request)
    {
        error_reporting(0);
    	$d = $request->all();
    	if(\Auth::guard('back')->attempt(['mg_name'=>$d['mg_name'],'password'=>$d['password']])){
            
            if(!$this->managerRepository->checkManagerSatatus()){
                return ['code'=>4,'error'=>'该账户被禁止登陆!'];
            }
    		//获取到对方的 ip 地址 和session id
			$ip = $request->getClientIp();
			$session_id = session()->getId();
            return $this->managerRepository->checkIpAndSessionId($ip,$session_id) ? ['code'=>1] : ['code'=>0,'error'=>'ip地址禁止'];
    	};
    	return ['code'=>0,'error'=>'登录用户或者密码不正确!'];
    }

    //退出登录
    public function logout()
    {
        $this->managerRepository->rememberLastTime();
        Auth::guard('back')->logout();
        return redirect()->route('login');    
    }

    //用户添加页面
    public function create(Request $request)
    {
        $role =  $this->roelRepository->getRoleData();

        return view('admin.manager.create',compact('role'));
    }
    //用户添加保存
    public function stroe(StoreManagerRequest $request)
    {
        $z = $this->managerRepository->stroeManager($request->all());

        return $z ? ['code'=>1] : ['code'=>0];
    }

    //用户编辑显示
    public function edit(Request $request,$mg_id)
    {
        $role =  $this->roelRepository->getRoleData();
        $manager = $this->managerRepository->getManagerById($mg_id);

        return view('admin.manager.edit',compact('role','manager'));
    }

    //用户编辑更新
    public function update(StoreManagerRequest $request)
    {
        $z = $this->managerRepository->updateManager($request->all());

        return $z ? ['code'=>1]:['code'=>0];
    }

    //超级用户给用户重置密码
    public function resetpwd(Request $request)
    {
        if($request->isMethod('post')){
            $z = $this->managerRepository->updatepwd($request->all());
            return $z ? ['code'=>1] : ['code'=>0,'error'=>'不是超级用户'];
        }
        $manager = $this->managerRepository->getManagerById($request->route('mg_id'));
        return view('admin.manager.resetpwd',compact('manager'));
    }

}
