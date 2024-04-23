<?php

namespace application\src\utils;

class SessionManager
{

    public function getSessionVariable($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return null;
        }
    }

    public function setSessionVariable($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function unsetSessionVariable($key)
    {
        unset($_SESSION[$key]);
    }
}