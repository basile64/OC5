<?php

namespace application\src\models\router;

class Route{
    private $path;
    private $callable;
    private $matches;

    public function __construct($path, $callable){
        $this->setPath($path);
        $this->setCallable($callable);
    }

    private function setPath($path){
        $this->path = trim($path, "/");
    }

    private function setCallable($callable){
        $this->callable = $callable;
    }

    public function match($url){
        $url = trim($url, "/");
        $path = preg_replace("#:([\w]+)#","([^/]+)", $this->path);
        $regex = "#^$path$#i";
        if (!preg_match($regex, $url, $matches)){
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;
        return true;
    }

    public function call(){
        return call_user_func_array($this->callable, $this->matches);
    }

}