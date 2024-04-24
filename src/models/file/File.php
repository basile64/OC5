<?php

namespace application\src\models\file;

class File
{
    private $name;
    private $type;
    private $size;
    private $tempName;
    private $extension;

    public function __construct($key)
    {
        $fileInfo = $_FILES[$key];
        $this->setName(isset($fileInfo["name"]) ? $fileInfo["name"] : null);
        $this->setType(isset($fileInfo["type"]) ? $fileInfo["type"] : null);
        $this->setSize(isset($fileInfo["size"]) ? $fileInfo["size"] : null);
        $this->setTempName(isset($fileInfo["tmp_name"]) ? $fileInfo["tmp_name"] : null);
        $this->setExtension(isset($fileInfo["name"]) ? pathinfo($fileInfo["name"], PATHINFO_EXTENSION) : null);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function getTempName()
    {
        return $this->tempName;
    }

    public function getExtension()
    {
        return $this->extension;
    }

    private function setName($name){
        $this->name = $name;
    }

    private function setType($type){
        $this->type = $type;
    }

    private function setSize($size){
        $this->size = $size;
    }

    private function setTempName($tempName){
        $this->tempName = $tempName;
    }

    private function setExtension($extension){
        $this->extension = $extension;
    }

}
