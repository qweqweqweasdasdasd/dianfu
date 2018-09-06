<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\FenpeiRepository;

class Yun extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yun';   //php artisan yun

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(FenpeiRepository $fenpeiRepository)
    {
        parent::__construct();
        $this->fenpeiRepository = $fenpeiRepository;    //注入对象
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()       //输出的内容
    {
        //执行代码
        //工作分配表启用的规则
        $fenpeiData = $this->fenpeiRepository->getFenpeiStatusDataTrue();
        
        //格式化数据插入jobs
        $this->fenpeiRepository->insertJobsData($fenpeiData);
        echo  date('Y-m-d H:i:s') . " renwu is ok , start working";
    }
}
