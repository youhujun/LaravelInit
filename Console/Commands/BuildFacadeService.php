<?php
/*
 * @Descripttion: 创建门面及服务的自定义命令
 * @version: 1.0.0
 * @Author: YouHuJun
 * @Date: 2020-02-21 17:59:40
 * @LastEditors: YouHuJun
 * @LastEditTime: 2020-02-21 23:51:15
 */

namespace YouHuJun\LaravelInit\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand as Command;
//use Illuminate\Console\Command;

class BuildFacadeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'facade:service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'FacadeService';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    /* public function __construct()
    {
        parent::__construct();
    } */

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $stub = null;

        $stub = '/stubs/service.stub';

        return __DIR__.$stub;
    }

    /**
     * Parse the class name and format according to the root namespace.
     *
     * @param  string  $name
     * @return string
     */
    protected function qualifyClass($name)
    {
        $name = ltrim($name, '\\/');

        $rootNamespace = $this->rootNamespace();

        if (Str::startsWith($name, $rootNamespace)) {
            return $name;
        }

        $name = str_replace('/', '\\', $name);
       
        return $this->qualifyClass(
            $this->getDefaultNamespace(trim($rootNamespace, '\\')).'\\'.'Service'.'\\'.'Facade'.'\\'.$name
        );
        
    }

   
}
