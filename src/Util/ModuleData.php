<?php

namespace Codeurx\Modular\Util;

use Illuminate\Support\Facades\Schema;

class ModuleData
{
    public function getModulesArray()
    {
        return Module::all()->toArray();
    }

    public function getModulesBootNameSpace()
    {
        $namespace = [];
        foreach($this->getModulesArray() as $value){
            if($value['active']) {
                $namespace[$value['name']] = 'App\\Modules\\'.$value['name'];
            }
        }
        return $namespace;
    }

    public function hasTable() {
        if(!Schema::hasTable(config('modular.table_name'))){
            return false;
        }
        return true;
    }

    public function CountEnabled()
    {
        return Module::where('active',1)->count();
    }

    public function CountDisabled()
    {
        return Module::where('active',0)->count();
    }

    public function ModuleExist($name)
    {
        return Module::where('name',$name)->count();
    }

    public function RemoveFromDB($name)
    {
        return Module::where('name',$name)->delete();
    }

    public function SaveModuleToDB($name)
    {
        $module = new Module;
        $module->name = $name;
        $module->alias = $name;
        $module->save();
    }

    public function active($name, $value)
    {
        $module = Module::where('name', $name)->first();
        $module->active = $value;
        $module->save();
    }

    public function ControllerExist($module,$controller)
    {
        return file_exists(base_path('app/Modules/'.$module.'/Http/Controllers/'.$controller.'.php'));
    }

    public function CreateController($module,$controller)
    {
        with(new ModuleManager(ucfirst($module)))->makeController($controller);
    }

    public function ModelExist($module,$model)
    {
        return file_exists(base_path('app/Modules/'.$module.'/Http/Models/'.$model.'.php'));
    }

    public function CreateModel($module,$model)
    {
        with(new ModuleManager(ucfirst($module)))->makeModel($model);
    }
}