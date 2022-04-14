<?php

namespace app\core;

class Application
{
    public static Application $app;
    public Router $router;
    public Request $request;
    public View $view;
    public ?Controller $controller = null;
    public static string $root_directory;
    public string $layout = 'main';

    public function __construct($path)
    {
        self::$app = $this;
        $this->request = new Request();
        $this->router = new Router($this->request);
        self::$root_directory = $path;
        $this->view = new View();
    }

    public function run()
    {
        echo $this->router->resolve();
    }

}