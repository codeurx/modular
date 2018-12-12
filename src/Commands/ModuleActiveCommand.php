<?php

namespace Codeurx\Modular\Commands;

use Codeurx\Modular\Util\ModuleData;
use Illuminate\Console\Command;

class ModuleActiveCommand extends Command
{
    protected $signature = 'modular:active {module : name of the module} {option : true or false}';

    protected $description = 'Activate/Disable a specific module.';

    protected $moduleData;

    public function __construct(ModuleData $moduleData)
    {
        parent::__construct();
        $this->moduleData = $moduleData;
    }

    public function handle()
    {
        if(!$this->moduleData->hasTable()){
            $this->info("Modules table does not exist please follow the module documentation!");
            return;
        }
        $name = $this->argument('module');
        if($this->moduleData->ModuleExist($name)==0) {
            $this->error('Module "'.$module. '" does not exist!');
            return false;
        }
        $option = $this->argument('option');
        if ($option == 'true' || $option == 'false') {
            if($option == 'true') {
                $this->moduleData->active($name,1);
                $this->info('module is activated!.');
            }
            else if($option == 'false') {
                $this->moduleData->active($name,0);
                $this->info('module is disable!.');
            }
        }
        else {
            $this->error('option not valid, please insert "true or false"');
            return false;
        }
    }
}