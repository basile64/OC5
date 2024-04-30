<?php

namespace application\src\models\category;

use application\src\models\database\DbConnect;

/**
 * Provides methods to manage category entity.
 */
class CategoryManager
{
    
    /**
     * Retrieves all categories from the database.
     *
     * @return array An array of Category objects.
     */
    public function getAll()
    {
        $query = "SELECT * FROM category";
        $result = DbConnect::executeQuery($query);
        $categories = [];

        foreach ($result as $categoryData) {
            $categories[] = new Category($categoryData);
        }

        return $categories;
    }

    /**
     * Retrieves a category by its ID from the database.
     *
     * @param int $id The category ID.
     * @return Category|null The Category object if found, otherwise null.
     */
    public function getCategory($id)
    {
        $query = "SELECT * FROM category WHERE id = :id";
        $params = [":id" => $id];
        $result = DbConnect::executeQuery($query, $params);

        if (!empty($result)) {
            return new Category($result[0]);
        }

        return null;
    }
}
