<?php

namespace Codeurx\Modular\Commands;

use Illuminate\Console\Command;
use Codeurx\Modular\Util\ModuleData;

class DatabaseBaseCommand extends Command
{

    protected $module;

    protected $moduledt;

    public function __construct(ModuleData $moduledt)
    {
        parent::__construct();
        $this->moduledt = $moduledt;
    }

    protected function getMigrationPath()
    {
        return $this->getDatabaseBasePath().DIRECTORY_SEPARATOR.'Migrations';
    }

    protected function getBasePath()
    {
        return base_path('app/Modules/'.$this->module);
    }

    protected function getDatabaseBasePath()
    {
        return base_path('app/Modules/'.$this->module.'/Database');
    }

    protected function getModuleNameArray($array)
    {
        $names = [];
        foreach($array as $key => $value ){
            $names[] = $value['name'];
        }
        return $names;
    }
}
