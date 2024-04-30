<?php

namespace application\src\models\category;

/**
 * Represents a category entity.
 */
class Category
{
    
    /**
     * ID column name.
     */
    private const ID_COLUMN = 'id';

    /**
     * Name column name.
     */
    private const NAME_COLUMN = 'name';

    /**
     * The category ID.
     *
     * @var int|null
     */
    private $id;

    /**
     * The category name.
     *
     * @var string|null
     */
    private $name;

    /**
     * Constructor to initialize the category object.
     *
     * @param array $category An associative array representing a category.
     */
    public function __construct($category)
    {
        $this->setId($category[self::ID_COLUMN] ?? null);
        $this->setName($category[self::NAME_COLUMN] ?? null);
    }

    /**
     * Get the category ID.
     *
     * @return int|null The category ID.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the category name.
     *
     * @return string|null The category name.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the category ID.
     *
     * @param int|null $id The category ID.
     * @return void
     */
    private function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Set the category name.
     *
     * @param string|null $name The category name.
     * @return void
     */
    private function setName($name)
    {
        $this->name = $name;
    }
}
