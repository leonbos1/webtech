<?php

namespace app\core;

use app\core\container\Container;
use app\models\Session as sessionModel;
use app\models\User;

class Application
{
    public static Application $app;
    private Database $database;
    public static string $root_directory;

    public function __construct(Container $container,$path, array $config, Router $router)
    {
        $this->container = $container;
        self::$app = $this;
        self::$root_directory = $path;
        $this->database = new Database($config['database']);
        $this->response = $container->get('app\core\Response');
        $this->controller = $container->get('app\core\Controller');
        $this->router = $router;
        $this->router->setContainer($this->container);
        session_start();
        $this->auth = new Authentication();
    }

    public function run()
    {
        echo $this->router->resolve();
    }

    public function setController(Controller $controller) {
        $this->controller = $controller;
    }

    public function getDatabase() {
        return $this->database;
    }

    public function getContainer()
    {
        return $this->container;
    }

}