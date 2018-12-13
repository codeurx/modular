<?php

namespace Codeurx\Modular\Util;

use Illuminate\Console\Command as Console;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;

class ModuleManager 
{
    protected $name;

    protected $plain;

    protected $console;

    protected $path;

    protected $filesystem;

    protected $moduledata;

    public function __construct(
        $name = null,
        Console $console = null,
        Filesystem $filesystem = null,
        ModuleData $moduleData = null
    ){
        $this->name = $name;
        if($console!==null)
            $this->console = $console;
        if($filesystem!==null)
            $this->filesystem = $filesystem;
        if($moduleData!==null)
            $this->moduledata = $moduleData;
    }

    public function generate()
    {
        $this->name = $this->getName();
        if($this->checkModule($this->name)==1){
            if (!$this->console->confirm('The Module ['.$this->name.'] Already  exist, do you wish to Continue?',false)) {
                $this->console->info("Process terminated by user");
                return;
            }
            $this->deleteModule($this->getBasePath());
            $this->moduledata->RemoveFromDB($this->name);
        }
        $this->makeModule();
        $this->console->info("Module [$this->name] Created Successfully!");
    }

    public function getName()
    {
        return Str::studly($this->name);
    }

    public function setConsole($console)
    {
        $this->console = $console;
        return $this;
    }

    public function setPlain($plain)
    {
        $this->plain = $plain;
        return $this;
    }

    public function setFilesystem($filesystem)
    {
        $this->filesystem = $filesystem;
        return $this;
    }

    protected function checkModule($name){
        if($this->moduledata == null)
            $this->moduledata = new ModuleData();
        return $this->moduledata->ModuleExist($name);
    }

    protected function deleteModule($target) {
        if(is_dir($target)){
            $files = glob($target.'*',GLOB_MARK);
            foreach($files as $file ){
                $this->deleteModule($file);
            }
            rmdir($target);
        } elseif(is_file($target)) {
            unlink( $target );
        }
    }

    protected  function makeModule(){
        $path = $this->getBasePath();
        $name = $this->name;
        $this->makeDirectory($path);
        $this->makeDirectory($path.'Http/Controllers');
        $this->makeDirectory($path.'Resources/views');
        $this->makeDirectory($path.'Resources/views/layouts');
        $this->makeDirectory($path.'Resources/assets');
        $this->makeDirectory($path.'Resources/assets/css');
        $this->makeDirectory($path.'Resources/assets/js');
        $this->makeDirectory($path.'Http/Models');
        $this->makeDirectory($path.'Routes');
        $this->makeDirectory($path.'Providers');
        $this->makeDirectory($path.'Database/Migrations');
        $this->generateStub('app/Modules/'.$name.'/Routes/web.php','Web',['CLASS'=>$name.'Controller','NAMESPACE'=>"App\Modules\\$name\Controllers",'NAME'=>$name,'LOWERNAME'=>strtolower($name)]);
        $this->generateStub('app/Modules/'.$name.'//Providers//'.$name.'ServiceProvider.php','ServiceProvider',['NAME'=>$name,'NAMESPACE'=>"App\Modules\\$name\Providers",'NAME'=>$name,'PREFIX'=>strtolower($name)]);
        $this->generateStub('app/Modules/'.$name.'/Http/Controllers/'.$name.'Controller.php','Controller',['CLASS'=>$name.'Controller','NAMESPACE'=>"App\Modules\\$name\Http\Controllers",'NAME'=>$name]);
        $this->generateStub('app/Modules/'.$name.'/Http/Models/'.$name.'Model.php','Model',['CLASS'=>$name.'Model','NAMESPACE'=>"App\Modules\\$name\Http\Models"]);
        $this->generateStub('app/Modules/'.$name.'/Resources/views/index.blade.php','View',['NAME'=>$name]);
        $this->moduledata->SaveModuleToDB($this->name);
    }

    protected function getBasePath()
    {
        return base_path('app/Modules/'.$this->getStudly().'/');
    }

    protected function getStudly()
    {
        return Str::studly($this->name);
    }

    protected function makeDirectory($path)
    {
        $this->filesystem->makeDirectory($path, 0777, true, true);
        return $path;
    }

    protected function generateStub($file,$stub,$content = []){
        return file_put_contents($file, $this->getContents($stub,$content));
    }

    protected function getContents($stub,$content)
    {
        $contents = file_get_contents(base_path().'/vendor/codeurx/modular/src/Commands/stubs/'.$stub.'.stub');
        foreach ($content as $search => $replace) {
            $contents = str_replace('$' . strtoupper($search) . '$', $replace, $contents);
        }
        return $contents;
    }

    public function delete(){
        $this->name = $this->getName();
        if($this->checkModule($this->name)==1){
            if (!$this->console->confirm('Are you sure to delete this module ['.$this->name.']?',false)) {
                $this->console->info("The module [$this->name] is in safe!");
                return;
            }
            $this->deleteModule($this->getBasePath());
            $this->moduledata->RemoveFromDB($this->name);
            $this->console->info("Module [$this->name] was Deleted Successfully!");
        }else{
            if (!$this->console->confirm('The module ['.$this->name.'] does not exist, do you want to create it?',false)) {
                $this->console->info("Process terminated by user");
                return;
            }
            $this->makeModule();
            $this->console->info("Module [$this->name] Created Successfully!");
        }
    }

    public function makeController($controller)
    {
        $class =  $this->getClassName($controller);
        $file = 'app/Modules/'.$this->name.'/Http/Controllers/'.$controller.'.php';
        $namespace = $this->getNameSpace($file);
        $folder = str_replace('\\','/',$namespace);
        if(!is_dir(lcfirst($folder))){
            mkdir(lcfirst($folder));
        }
        $this->generateStub($file,'controller-command',['CLASS'=>$class,'NAMESPACE'=>$namespace]);
    }

    public function makeModel($model)
    {
        $class =  $this->getClassName($model);
        $file = 'app/Modules/'.$this->name.'/Http/Models/'.$model.'.php';
        $namespace = $this->getNameSpace($file);
        $folder = str_replace('\\','/',$namespace);
        if(!is_dir(lcfirst($folder))){
            mkdir(lcfirst($folder));
        }
        $this->generateStub($file,'model-command',['CLASS'=>$class,'NAMESPACE'=>$namespace]);
    }

    protected function getClassName($str){
        $str=implode("",explode("\\",$str));
        $str=explode("/",$str);
        $str=end($str);
        return $str;
    }

    protected function getNameSpace($str){
        $str = str_replace('.php','',$str);
        $str = ucfirst(str_replace('/','\\',$str));
        $arr = explode('\\',$str);
        $last = end($arr);
        return str_replace('\\'.$last,'',$str);
    }
}
