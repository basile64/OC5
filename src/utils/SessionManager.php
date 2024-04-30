<?php

namespace application\src\utils;

/**
 * Provides methods to manage session variables.
 */
class SessionManager
{
    
    /**
     * Get the value of a session variable.
     *
     * @param string $key The key of the session variable.
     * @return mixed|null The value of the session variable if it exists, otherwise null.
     */
    public function getSessionVariable($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return null;
        }
    }

    /**
     * Set the value of a session variable.
     *
     * @param string $key The key of the session variable.
     * @param mixed $value The value to set.
     */
    public function setSessionVariable($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Unset a session variable.
     *
     * @param string $key The key of the session variable to unset.
     */
    public function unsetSessionVariable($key)
    {
        unset($_SESSION[$key]);
    }
}
