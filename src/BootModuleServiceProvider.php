<?php

namespace Codeurx\Modular;

use Illuminate\Support\ServiceProvider;
use Codeurx\Modular\Util\ModuleData;

class BootModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
        $md = new ModuleData;
        if($md->hasTable()) {
            foreach ($md->getModulesBootNameSpace() as $key => $value) {
                $class = $value.'\Providers\\'.$key.'ServiceProvider';
                if(class_exists($class)){
                    $this->app->register($class);
                }
            }
        }
    }
}