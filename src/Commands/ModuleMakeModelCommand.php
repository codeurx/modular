<?php

namespace Codeurx\Modular\Commands;

use Illuminate\Console\Command;
use Codeurx\Modular\Util\ModuleData;
use Illuminate\Support\Str;

class ModuleMakeModelCommand extends Command
{
    protected $signature = 'modular:make-model {module : The name of the module.} {model : The name of the model.}';

    protected $description = 'Create a new model for a specific module.';

    protected $moduledt;

    public function __construct(ModuleData $moduledt)
    {
        parent::__construct();
        $this->moduledt = $moduledt;
    }

    public function handle()
    {
        $module = Str::studly($this->argument('module'));
        $model = Str::studly($this->argument('model'));
        $this->module = $module;
        if($this->moduledt->ModuleExist($module)==0){
            $this->error('Module '.$module.' doesn\'t exist.');
            return false;
        }
        if($this->moduledt->ModelExist($module,$model)) {
            $this->error('Model "'.$model.'" already exist!;');
            return false;
        }
        $this->moduledt->CreateModel($module,$model);
        $this->info("Model [$model] Created Successfully!");
    }
}
