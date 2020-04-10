<?php

namespace Codeurx\Modular\Commands;

use Illuminate\Console\Command;
use Codeurx\Modular\Util\Module;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Codeurx\Modular\Util\ModuleMigrator;
use Codeurx\Modular\Util\ModuleData;

class ModuleMigrateCommand extends Command
{
    protected $signature = 'modular:migrate {module?}';

    protected $description = 'Migrates module';

    protected $migrator;

    protected $moduledt;

    protected $filesystem;

    public function __construct(ModuleData $moduledt, ModuleMigrator $migrator)
    {
        parent::__construct();
        $this->moduledt = $moduledt;
        $this->migrator = $migrator;
        $this->filesystem = new Filesystem();
    }

    public function handle()
    {
        $name = Str::studly($this->argument('module'));
        $this->migrator->migrate($name);
        if($this->moduledt->ModuleExist($name)==0) {
            $this->error('Module "'.$name. '" does not exist!');
            return false;
        }
        if(!$this->filesystem->exists('app/Modules/'.$name.'/Database/Migrations/')){
            $this->error('Module '.$name.' doesn\'t have migrations.');
            return false;
        }
        $modules = Module::all();
        foreach ($modules as $module) {
            $this->output->writeln('Module Name: '.$module->name);
            if(!$this->filesystem->exists('app/Modules/'.$module->name.'/Database/Migrations/')){
                $this->error('Module '.$module->name.' doesn\'t have migrations.');
                return false;
            }else{
                $this->migrator->migrate($module->name);
            }
        }
    }
}
