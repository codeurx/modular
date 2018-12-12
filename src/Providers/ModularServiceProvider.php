<?php

namespace Codeurx\Modular\Providers;

use Illuminate\Support\ServiceProvider;
use Codeurx\Modular\Util\ModuleData;

class ModularServiceProvider extends ServiceProvider
{
    public function Boot()
    {
    }

    public function register()
    {
        $md = new ModuleData;
        foreach ($md->getModulesBootNameSpace() as $key => $value) {
            $class = $value.'\Providers\\'.$key.'ServiceProvider';
            if(class_exists($class)){
                $this->app->register($class);
            }
        }
    }
}