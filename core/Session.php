<?php

namespace app\core;

class Session
{

    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public function get($key) {
        if (isset($_SESSION[$key]) ) {
            return $_SESSION[$key];
        }
    }

    public function remove($key) {
        $_SESSION[$key] = null;
    }

}