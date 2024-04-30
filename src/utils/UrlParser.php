<?php

namespace application\src\utils;

/**
 * Parses the URL and provides methods to retrieve its components.
 */
class UrlParser
{
    /**
     * The full URL.
     *
     * @var string
     */
    private $url;
    
    /**
     * An array containing the components of the URL.
     *
     * @var array
     */
    private $explodedUrl;

    /**
     * UrlParser constructor.
     * 
     * Initializes the URL and parses it into its components.
     */
    public function __construct()
    {
        $this->setUrl($_SERVER["REQUEST_URI"]);
        return $this->setExplodedUrl();
    }

    /**
     * Get the full URL.
     *
     * @return string The full URL.
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get the exploded URL components.
     *
     * @return array The exploded URL components.
     */
    public function getExplodedUrl()
    {
        return $this->explodedUrl;
    }

    /**
     * Set the full URL.
     *
     * @param string $url The full URL.
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Parse the URL into its components.
     */
    public function setExplodedUrl()
    {
        $this->explodedUrl = explode("/", trim($this->url, "/"));
        array_shift($this->explodedUrl);
    }
}
