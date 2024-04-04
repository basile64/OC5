<?php

namespace application\src\models\category;

class Category {
    private $idCategory;
    private $nameCategory;

    public function __construct($category){
        $this->setId($category['idCategory'] ?? null);
        $this->setName($category['nameCategory'] ?? null);
    }

    // Getters
    public function getId(){
        return $this->idCategory;
    }

    public function getName(){
        return $this->nameCategory;
    }

    // Setters
    public function setId($idCategory){
        $this->idCategory = $idCategory;
    }

    public function setName($nameCategory){
        $this->nameCategory = $nameCategory;
    }
}
