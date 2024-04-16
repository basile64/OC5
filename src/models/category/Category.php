<?php

namespace application\src\models\category;

class Category {
    private const ID_COLUMN = 'id';
    private const NAME_COLUMN = 'name';

    private $id;
    private $name;

    public function __construct($category){
        $this->setId($category[self::ID_COLUMN] ?? null);
        $this->setName($category[self::NAME_COLUMN] ?? null);
    }

    // Getters
    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    // Setters
    private function setId($id){
        $this->id = $id;
    }

    private function setName($name){
        $this->name = $name;
    }
}
