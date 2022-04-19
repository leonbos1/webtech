<?php

namespace app\core;

class Response {

    public $http_codes = array(
        200 => 'HTTP/1.1 200 OK',
        201 => 'HTTP/1.1 201 Created',
        400 => 'HTTP/1.1 400 Bad Request',
        401 => 'HTTP/1.1 401 Unauthorized',
        403 => 'HTTP/1.1 403 Forbidden',
        404 => 'HTTP/1.1 404 Not Found'
    );

    public function statusCode($statuscode) {
        header($this->http_codes[$statuscode]);
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