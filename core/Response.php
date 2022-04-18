<?php

namespace app\core;

class Response {

    public function statusCode($statuscode) {
        http_response_code($statuscode);
    }

    public function setCookie($key,$value,$expire) {
        setcookie($key,$value,$expire);
    }

    public function getCookie($key) {
        if (isset($_COOKIE[$key])) {
            return $_COOKIE[$key];
        }
    }

    public function removeCookie($key) {
        setcookie("$key", "", time() - 3600);
    }

}