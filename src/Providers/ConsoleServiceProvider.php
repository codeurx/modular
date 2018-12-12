<?php

namespace Codeurx\Modular\Providers;

use Illuminate\Support\ServiceProvider;

use Codeurx\Modular\Commands\ModuleMakeCommand;

class ConsoleServiceProvider extends ServiceProvider
{
    protected $defer = false;

    protected $commands = [
        ModuleMakeCommand::class,
    ];

    public function register()
    {
        $this->commands($this->commands);
    }

    public function provides()
    {
        $provides = $this->commands;

        return $provides;
    }
}
