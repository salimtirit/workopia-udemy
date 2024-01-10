<?php

namespace Framework;

class Session
{
    /**
     * Start the session if it is not already started
     *
     * @return void
     */
    public static function start()
    {
        if (session_status() == PHP_SESSION_NONE)
            session_start();
    }

    /**
     * Set a session key/value pair
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Get a session value by key
     *
     * @param string $key
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        if (!isset($_SESSION[$key])) return $default;
        return $_SESSION[$key];
    }

    /**
     * Destroy the session
     *
     * @return void
     */
    public static function destroy()
    {
        session_unset();
        session_destroy();
    }

    /**
     * Clar a session key
     *
     * @param string $key
     * @return void
     */
    public static function clear($key)
    {
        if (isset($_SESSION[$key]))
            unset($_SESSION[$key]);
    }

    /**
     * Check if a session key exists
     *
     * @param string $key
     * @return boolean
     */
    public static function has($key)
    {
        return isset($_SESSION[$key]);
    }
}
