<?php

namespace Codeurx\Modular\Util;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table;

    public function __construct(array $attributes = [])
    {
        $this->setTable(config('modular.table_name'));
        parent::__construct($attributes);
    }

}
