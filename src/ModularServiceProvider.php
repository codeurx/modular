<?php

namespace Codeurx\Modular;

use Illuminate\Support\Facades\DB;
use Codeurx\Modular\Commands\ModuleMakeCommand;
use Codeurx\Modular\Commands\ModuleDeleteCommand;
use Codeurx\Modular\Commands\ModulesListCommand;
use Codeurx\Modular\Commands\ModuleActiveCommand;
use Codeurx\Modular\Commands\ModuleCreateMigrationCommand;
use Codeurx\Modular\Commands\ModuleMigrateCommand;
use Codeurx\Modular\Commands\ModuleMakeControllerCommand;
use Codeurx\Modular\Commands\ModuleMakeModelCommand;
use Illuminate\Support\ServiceProvider;

class ModularServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->makeDirectory();
        $this->publishesConfig();
        $this->publishesMigrations();
        $this->publishesCommands();
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration.");
        }
        $this->app->register(BootModuleServiceProvider::class);
    }

    public function register()
    {
        $this->app->singleton('modular', function($app) {
            return new RepositoryService([]);
        });
        $this->mergeConfigFrom(__DIR__.'/Config/config.php', 'modular');
    }

    protected function publishesConfig()
    {
        $this->publishes([__DIR__.'/Config/config.php' => config_path('modular.php'),], 'config');
        $this->mergeConfigFrom(__DIR__.'/Config/config.php', 'modular');
    }

    protected function makeDirectory(){
        if ( !(is_dir(base_path('app/Modules/'))) ) {
            \File::makeDirectory(base_path('app/Modules/'),0775, true, true);
            \File::makeDirectory(base_path('app/Modules/helpers/'),0775, true, true);
            \File::copy(__DIR__.'/Helpers/helpers.php',base_path('app/Modules/helpers/helpers.php'));
        }
    }

    protected function publishesCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ModuleMakeCommand::class,
                ModuleDeleteCommand::class,
                ModulesListCommand::class,
                ModuleActiveCommand::class,
                ModuleCreateMigrationCommand::class,
                ModuleMigrateCommand::class,
                ModuleMakeControllerCommand::class,
                ModuleMakeModelCommand::class,
            ]);
        }
    }

    protected function publishesMigrations(){
        $timestamp = date('Y_m_d_His', time());
        $this->publishes([__DIR__.'/Database/migrations/create_modules_table.php' => database_path('migrations/'.$timestamp.'_create_modules_table.php')],'migrations');
    }
}
