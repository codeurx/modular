<?php

namespace Codeurx\Modular\Commands;

use Codeurx\Modular\Util\ModuleData;
use Illuminate\Console\Command;

class ModulesListCommand extends Command
{
    protected $name = 'modular:list';

    protected $description = 'List all the modules.';

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
        $headers = ['#','Name', 'Alias','Active', 'Created at', 'Updated at'];
        $modules = $this->moduleData->getModulesArray();
        foreach ($modules as $pos => $module) {
            if($module['active'] == 1){
                $modules[$pos]['active'] = 'true';
            }
            else if ($module['active'] == 0){
                $modules[$pos]['active'] = 'false';
            }
        }
        $this->table($headers, $modules);
        $this->info("You have ".sizeof($modules)." Module(s), ".$this->moduleData->CountEnabled()." Module(s) Enabled, ".$this->moduleData->CountDisabled()." Module(s) Disabled.");
    }
}
