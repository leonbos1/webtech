<?php

namespace app\core;

use app\core\container\Container;
use app\core\Session;
use app\models\Session as sessionModel;
use app\models\User;

class Application
{
    public static Application $app;
    public Request $request;
    public View $view;
    public Database $database;
    public ?Controller $controller = null;
    public static string $root_directory;
    public string $layout = 'main';
    public Container $container;
    public Session $session;

    public function __construct(Container $container,$path, array $config, protected ?Router $router = null)
    {
        $this->container = $container;
        self::$app = $this;
        self::$root_directory = $path;
        $this->request = new Request();
        $this->view = new View();
        $this->database = new Database($config['database']);
        $this->session = new Session();
        session_start();

    }

    public function run()
    {
        echo $this->router->resolve();
    }

    public function LoggedIn() {

        $session_id = Application::$app->container->resolve(Response::class)->getCookie('session_id');

        if (!isset($session_id)) {
            return false;
        }

        $session = sessionModel::findOne(['session_id' => $session_id]);

        if (!$session) {
            return false;
        }

        $expire_date = $session->expire_date;
        $expire_date = date_create($expire_date);
        $expire_date = date_add($expire_date, date_interval_create_from_date_string("1 day"));
        $expire_date = date_format($expire_date,"Y-m-d H:m:s");
        $current_date = date("Y-m-d H:m:s");

        if ($current_date > $expire_date) {
            Application::$app->controller->redirect('/logout');
            return false;
        }

        return true;

    }

    public function getUser() {
        $session_id = Application::$app->container->resolve(Response::class)->getCookie('session_id');
        $session = sessionModel::findOne(['session_id' => $session_id]);
        $user_id = $session->user_id;
        return User::findOne(['id'=>$user_id]);
    }

    public function isAdmin() {
        $user = Application::$app->getUser();

        if ($user->role != 'admin') {
            return false;
        }
        return true;
    }

}