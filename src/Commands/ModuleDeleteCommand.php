<?php

namespace Codeurx\Modular\Commands;

use Codeurx\Modular\Util\ModuleData;
use Codeurx\Modular\Util\ModuleManager;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class ModuleDeleteCommand extends Command
{
    protected $name = 'modular:delete';

    protected $description = 'Delete a specific module.';

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
        $names = $this->argument('name');
        foreach ($names as $name){
            with(new ModuleManager(ucfirst($name)))
                ->setConsole($this)
                ->setFilesystem($this->laravel['files'])
                ->delete();
        }
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::IS_ARRAY, 'The name of module will be created.'],
        ];
    }
}
