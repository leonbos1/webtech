<?php

namespace app\core;

use app\core\services\AuthService;

class Authentication
{
    public static Authentication $auth;
    private AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService(new Response());
        self::$auth = $this;
    }

    public function getUser() {
        return $this->authService->getUser();
    }

    public function loggedIn() {
        return $this->authService->LoggedIn();
    }

    public function isAdmin() {
        return $this->authService->isAdmin();
    }

}