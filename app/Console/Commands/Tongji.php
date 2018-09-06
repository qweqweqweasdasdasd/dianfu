<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\JobsRepository;

class Tongji extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tongji';

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
    public function __construct(JobsRepository $jobsRepository)
    {
        parent::__construct();
        $this->jobsRepository = $jobsRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $z = $this->jobsRepository->updateBymgidWithh_sum();

        echo  date('Y-m-d H:i:s') . " tongji is ok , start working";
    }
}
