<?php

namespace application\src\models\file;

/**
 * Represents a file.
 */
class File
{
    
    /**
     * The name of the file.
     */
    private $name; // Name of the file

    /**
     * The MIME type of the file.
     */
    private $type; // MIME type of the file

    /**
     * The size of the file in bytes.
     */
    private $size; // Size of the file in bytes

    /**
     * The temporary name assigned to the file.
     */
    private $tempName; // Temporary name assigned to the file

    /**
     * The extension of the file.
     */
    private $extension; // Extension of the file

    /**
     * Constructor method.
     *
     * @param string $key The key of the file in the $_FILES array.
     */
    public function __construct($key)
    {
        $fileInfo = $_FILES[$key];
        $this->setName(isset($fileInfo["name"]) ? $fileInfo["name"] : null);
        $this->setType(isset($fileInfo["type"]) ? $fileInfo["type"] : null);
        $this->setSize(isset($fileInfo["size"]) ? $fileInfo["size"] : null);
        $this->setTempName(isset($fileInfo["tmp_name"]) ? $fileInfo["tmp_name"] : null);
        $this->setExtension(isset($fileInfo["name"]) ? pathinfo($fileInfo["name"], PATHINFO_EXTENSION) : null);
    }

    /**
     * Gets the name of the file.
     *
     * @return string The name of the file.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Gets the MIME type of the file.
     *
     * @return string The MIME type of the file.
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Gets the size of the file in bytes.
     *
     * @return int The size of the file in bytes.
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Gets the temporary name assigned to the file.
     *
     * @return string The temporary name assigned to the file.
     */
    public function getTempName()
    {
        return $this->tempName;
    }

    /**
     * Gets the extension of the file.
     *
     * @return string The extension of the file.
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Sets the name of the file.
     *
     * @param string $name The name of the file.
     */
    private function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Sets the MIME type of the file.
     *
     * @param string $type The MIME type of the file.
     */
    private function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Sets the size of the file in bytes.
     *
     * @param int $size The size of the file in bytes.
     */
    private function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * Sets the temporary name assigned to the file.
     *
     * @param string $tempName The temporary name assigned to the file.
     */
    private function setTempName($tempName)
    {
        $this->tempName = $tempName;
    }

    /**
     * Sets the extension of the file.
     *
     * @param string $extension The extension of the file.
     */
    private function setExtension($extension)
    {
        $this->extension = $extension;
    }
}
