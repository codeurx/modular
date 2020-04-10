<?php

namespace Codeurx\Modular\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Illuminate\Support\Composer;
use Illuminate\Database\Migrations\MigrationCreator;
use Codeurx\Modular\Util\ModuleData;

class ModuleCreateMigrationCommand extends DatabaseBaseCommand
{
    protected $signature = 'modular:make-migration {module : The name of the module.}
        {--table= : The table to be created.}';

    protected $description = 'Create a new module migration file';

    protected $creator;

    protected $composer;

    protected $moduledt;

    public function __construct(Composer $composer,ModuleData $moduledt)
    {
        parent::__construct($moduledt);
        $this->composer = $composer;
        $this->moduledt = $moduledt;
        $this->creator = new MigrationCreator(new Filesystem(),null); 
    }

    public function handle()
    {
        $module = Str::studly($this->input->getArgument('module'));
        $this->module = $module;
        $table = $this->input->getOption('table')?: false;
        if($this->moduledt->ModuleExist($module)==0){
            $this->error('Module '.$module.' doesn\'t exist.');
            return false;
        }
        if (!$table) {
            $table = strtolower($module);
        }
        $name = 'create_'.$table.'_table';
        if (preg_match('/^create_(\w+)_table$/', $name, $matches)) {
                $table = $matches[1];
        }
        $this->writeMigration($name, $table, true);
        $this->composer->dumpAutoloads();
    }

    protected function writeMigration($name, $table, $create)
    {
        $file = pathinfo($this->creator->create(
            $name, $this->getMigrationPath(), $table, $create
        ), PATHINFO_FILENAME);
        $this->line("<info>Created Migration:</info> {$file}");
    }

    protected function getMigrationPath()
    {
        return parent::getMigrationPath();
    }
}
