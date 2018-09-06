<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\WhitelistRepository;

class WhitelistController extends Controller
{
	//私有属性
	protected $whitelistRepository;

	public function __construct(WhitelistRepository $whitelistRepository){
		
		$this->whitelistRepository = $whitelistRepository;
	}
	
    //显示列表
    public function index()
    {
    	$data = $this->whitelistRepository->getWhitelist();
    	$mg_index = $this->whitelistRepository->getMgNameIndex();
    	
    	return view('admin.whitelist.index',compact('data','mg_index'));
    }

    //保存白名单
    public function store(Request $request)
    {
        $d = $this->whitelistRepository->storeWhitelist($request->get('shuju'));

    	return $d ? ['code'=>1] : ['code'=>0];
    }

    //删除白名单
    public function destroy(Request $request)
    {
    	$z = $this->whitelistRepository->deletewhitelist($request->get('w_id'));

    	return $z ? ['code'=>1] : ['code'=>0];
    }
}
