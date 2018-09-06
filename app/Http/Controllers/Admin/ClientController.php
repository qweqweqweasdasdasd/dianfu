<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ImportRepository;
use App\Repositories\ClientRepository;
use App\Http\Requests\StoreClientRequest;

class ClientController extends Controller
{
	//私有属性;
	protected $importRepository;
	protected $clientRepository;

	//构造函数
	public function __construct(ImportRepository $importRepository,ClientRepository $clientRepository)
	{
		$this->importRepository = $importRepository;
		$this->clientRepository = $clientRepository;
	}
	//客户信息
	public function show(Request $request)
	{
		$key = $request->get('key') ? trim($request->get('key')):'';
		$client = $this->clientRepository->getClientData($key);
		$count = $this->clientRepository->countClient();
		
		return view('admin.client.show',compact('client','count','key'));
	}
    //客户导入显示页面
    public function index(Request $request)
    {
    	$k = $request->input('k') ? trim($request->input('k')) :'';
    	$data = $this->importRepository->getimportData($k);

    	return view('admin.client.index',compact('data','k'));
    }

    //客户详情页面
    public function info(Request $request)
    {	
    	$info = $this->clientRepository->getInfoById($request->route('u_id'));
    	
    	return view('admin.client.info',compact('info'));
    }

    //编辑页面显示
    public function edit(Request $request)
    {
    	$info = $this->clientRepository->getInfoById($request->route('u_id'));
   
    	return view('admin.client.edit',compact('info'));
    }
    
    //编辑更新数据
    public function update(StoreClientRequest $request)
    {
    	$z = $this->clientRepository->storeClientToData($request->all());
    	
    	return $z ? ['code'=>1] : ['code'=>0];
    }
}
