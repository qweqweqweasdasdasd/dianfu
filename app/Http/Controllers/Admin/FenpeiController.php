<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\RoleRepository;
use App\Repositories\FenpeiRepository;
use App\Http\Requests\StoreFenpeiRequest;

class FenpeiController extends Controller
{
    //私有属性
    protected $fenpeiRepository;
    protected $roleRepository;

    //构造函数
    public function __construct(FenpeiRepository $fenpeiRepository,RoleRepository $roleRepository)
    {
        $this->fenpeiRepository = $fenpeiRepository;
        $this->roleRepository = $roleRepository;
    }
    //工作分配显示
    public function index(Request $request)
    {
        $kk = $request->get('kk')? trim($request->get('kk')) : '';
        $data = $this->fenpeiRepository->getFenpeiData($kk);

    	return view('admin.fenpei.index',compact('data','kk'));
    }

    //添加显示
    public function create()
    {
        $role = $this->roleRepository->getRoleData();

    	return view('admin.fenpei.create',compact('role'));
    }

    //添加保存
    public function store(StoreFenpeiRequest $request)
    {
        $z = $this->fenpeiRepository->storeFenpeiDataToDB($request->all());

        return $z ? ['code'=>1] : ['code'=>0,'error'=>'一个用户组只能使用一条分配规则'];
    }

    //删除分配
    public function destroy(Request $request)
    {
        $z = $this->fenpeiRepository->deleteFenpeiById($request->get('f_id'));
        
        return $z ? ['code'=>1] : ['code'=>0,'error'=>'请先停用之后进行删除'];
    }

    //显示编辑
    public function edit(Request $request)
    {
        $role = $this->roleRepository->getRoleData();
        $info = $this->fenpeiRepository->getInfoById($request->route('f_id'));

        return view('admin.fenpei.edit',compact('role','info'));
    }

    //更新编辑
    public function update(StoreFenpeiRequest $request)
    {
        $z = $this->fenpeiRepository->updateFenpeiById($request->all());

        return $z ? ['code'=>1] : ['code'=>0,'error'=>'同一个用户组只能开启一条规则!'];
    }
}
