<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\RoleRepository;
use App\Repositories\JobsRepository;
use App\Repositories\FenpeiRepository;
use App\Repositories\ClientRepository;
use App\Http\Requests\StoreVisitRequest;

class WorkController extends Controller
{
	//私有属性
	protected $jobsRepository;
	protected $fenpeiRepository;

	//构造方法
	function __construct(JobsRepository $jobsRepository,FenpeiRepository $fenpeiRepository,ClientRepository $clientRepository)
	{
		$this->jobsRepository = $jobsRepository;
        $this->fenpeiRepository = $fenpeiRepository;
		$this->clientRepository = $clientRepository;
	}		
    //工作流显示 //显示简单的统计
    public function workflow()
    {
        $data = $this->jobsRepository->getjobsData();
        $todayCount = $this->jobsRepository->todayJobsCount();
        $yesterdayNook = $this->jobsRepository->yesterdayJobsNook();
        $todayOk = $this->jobsRepository->todayJobsOk();
        

        return view('admin.work.workflow',compact('data','todayCount','yesterdayNook','todayOk'));
    }


    //后台管理--定时任务:(根据设置的规则进行读取客户数据库把未回访的写入任务表)
    public function jobs()
    {
    	//工作分配表启用的规则
    	$fenpeiData = $this->fenpeiRepository->getFenpeiStatusDataTrue();
    	
    	//格式化数据插入jobs
    	return $this->fenpeiRepository->insertJobsData($fenpeiData);
    }


    //修改 状态 2
    public function workingstatus(Request $request)
    {
        $z = $this->jobsRepository->setworkingstatus_2($request->get('j_id'));

        return $z ? ['code'=>1] : ['code'=>0]; 
    }

    //添加回访显示
    public function add_visit(Request $request)
    {   
        $info = $this->jobsRepository->getJobInfo($request->route('j_id'));
        $jobs = $this->jobsRepository->getvisitByu_id($request->route('u_id'));
        $manager = $this->jobsRepository->mg_nameAndID();
        //dd($jobs);

        return view('admin.work.addvisit',compact('info','jobs','manager'));
    }

    //保存回访信息
    public function store(StoreVisitRequest $request)
    {
        $z = $this->jobsRepository->storeVisit($request->all());

        return $z ? ['code'=>1]:['code'=>0];
    }

    //回访记录
    public function visit(Request $request)
    {
        $todayOk = $this->jobsRepository->todayJobsOk();
        $countByMg = $this->jobsRepository->countByMg();
        $data = $this->jobsRepository->getVisitData();
        //dd($data);
        return view('admin.work.visit',compact('todayOk','countByMg','data'));
    }

    //查看会员信息
    public function info(Request $request)
    {
        $info = $this->clientRepository->getInfoById($request->route('u_id'));

        return view('admin.work.info',compact('info'));
    }

    //会员下面的回访信息
    public function visitzi(Request $request)
    {
        $jobs = $this->jobsRepository->getvisitByu_id($request->route('u_id'));
        $manager = $this->jobsRepository->mg_nameAndID();

        /*dd($jobs);*/
        return view('admin.work.visitzi',compact('jobs','manager'));
    }

    //退回重新回访
    public function rollback(Request $request)
    {
        $z = $this->jobsRepository->rollbackTosatus_0($request->get('j_id'));

        return $z ? ['code'=>1] : ['code'=>0];
    }

    //写入统计表
    public function total()
    {
        $z = $this->jobsRepository->updateBymgidWithh_sum();

        return 1;
    }
}
