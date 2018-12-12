<?php

namespace Codeurx\Modular\Facades;

use Illuminate\Support\Facades\Facade;

class Module extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'modules';
    }
}
