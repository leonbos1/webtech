<?php

namespace app\core;

class Application
{
    public static Application $app;
    public Router $router;
    public Request $request;
    public View $view;
    public Database $database;
    public ?Controller $controller = null;
    public static string $root_directory;
    public string $layout = 'main';
    public Session $session;
    public string $user = 'guest';

    public function __construct($path, array $config)
    {
        self::$app = $this;
        $this->request = new Request();
        $this->router = new Router($this->request);
        self::$root_directory = $path;
        $this->view = new View();
        $this->database = new Database($config['database']);
        $this->session = new Session();
        session_start();
    }

    public function run()
    {
        echo $this->router->resolve();
    }

    public function setUser(string $username)
    {
        Application::$app->session->set('user', $username);
    }

    public function getUser() {
        return Application::$app->session->get('user');
    }

    public function LoggedIn() {
        if (Application::$app->session->get('user') === 'guest') {
            return false;
        }
        return true;
    }

}