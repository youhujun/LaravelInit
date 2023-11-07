<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: YouHuJun
 * @Date: 2020-02-21 23:58:56
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2023-11-07 10:48:20
 */

namespace YouHuJun\LaravelInit\App\Console\Commands;

use Illuminate\Console\Command;

class CallFacadeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'call:facade {facadeName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "call create facade and it's service command ";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $param = $this->argument('facadeName');

        $this->call('make:facade', [
            'name' => $param
        ]);

        $this->call('facade:service', [
            'name' => $param
        ]);
        
    }
}
