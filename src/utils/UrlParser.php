<?php

namespace application\src\utils;

class UrlParser{
    private $url;
    private $explodedUrl;

    public function __construct(){
        $this->setUrl($_SERVER["REQUEST_URI"]);
        return $this->setExplodedUrl();
    }

    public function getUrl(){
        return $this->url;
    }

    public function getExplodedUrl(){
        return $this->explodedUrl;
    }

    public function setUrl($url){
        $this->url = $url;
    }

    public function setExplodedUrl(){
        $this->explodedUrl = explode("/", trim($this->url, "/"));
        array_shift($this->explodedUrl);
    }
}