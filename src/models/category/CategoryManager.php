<?php

namespace application\src\models\category;

use application\src\models\database\DbConnect;
use application\src\models\category\Category;

class CategoryManager {
    public static function getAll() {
        $query = "SELECT * FROM category";
        $result = DbConnect::executeQuery($query);
        $categories = [];

        foreach ($result as $categoryData) {
            $categories[] = new Category($categoryData);
        }

        return $categories;
    }

    public function getCategory($id){
        $query="
            SELECT
                *
            FROM
                category
            WHERE
                id = :id
        ";

        $params = [
            ":id" => $id
        ];

        $result = DbConnect::executeQuery($query, $params);
        $category = new Category($result[0]);
        return $category;
    }
}
