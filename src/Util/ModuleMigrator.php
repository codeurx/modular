<?php

namespace Codeurx\Modular\Util;

use Illuminate\Support\Facades\DB;

class ModuleMigrator
{
    protected $migrator;
    protected $moduledt;

    public function __construct()
    {
        $this->migrator = app('migrator');
        $this->moduledt = new ModuleData();
    }

    public function migrate($module_name)
    {
        $this->migrator->run($this->getMigrationPaths('app/Modules/'.$module_name.'/Database/Migrations/'),
            ['pretend' =>  null,
                'step'   =>  null,
            ]);
        return true;
    }
    protected function getMigrationPaths($paths)
    {
        return collect($paths)->map(function ($path) {
            return base_path().'/'.$path;
        })->all();
    }
}
