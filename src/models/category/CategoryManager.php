<?php

namespace application\src\models\category;

use application\src\models\database\DbConnect;
use application\src\models\category\Category;

class CategoryManager {
    public static function getAll() {
        $query = "SELECT idCategory, nameCategory FROM category";
        $result = DbConnect::executeQuery($query);
        $categories = [];

        foreach ($result as $categoryData) {
            $categories[] = new Category($categoryData);
        }

        return $categories;
    }

    public function getCategory($idCategory){
        $query="
            SELECT
                *
            FROM
                category
            WHERE
                idCategory = :idCategory
        ";

        $params = [
            ":idCategory" => $idCategory
        ];

        $result = DbConnect::executeQuery($query, $params);
        $category = new Category($result[0]);
        return $category;
    }
}
