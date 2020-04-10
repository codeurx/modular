<?php

namespace Codeurx\Modular\Commands;

use Illuminate\Console\Command;
use Codeurx\Modular\Util\ModuleData;
use Illuminate\Support\Str;
use PHPUnit\Util\Filesystem;

class ModuleMakeControllerCommand extends Command
{
    protected $signature = 'modular:make-controller {module : The name of the module.} {controller : The name of the controller.}';

    protected $description = 'Create a new controller for a specific module.';

    protected $moduledt;

    public function __construct(ModuleData $moduledt)
    {
        parent::__construct();
        $this->moduledt = $moduledt;
    }

    public function handle()
    {
        $module = Str::studly($this->argument('module'));
        $controller = Str::studly($this->argument('controller'));
        if($this->moduledt->ModuleExist($module)==0){
            $this->error('Module '.$module.' doesn\'t exist.');
            return false;
        }
        if($this->moduledt->ControllerExist($module,$controller)) {
            $this->error('Controller "'.$controller.'" already exist!;');
            return false;
        }
        $this->moduledt->CreateController($module,$controller);
        $this->info("Controller [$controller] Created Successfully!");
    }
}
