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
        $this->view = $container->get('app\core\View');
        $this->database = new Database($config['database']);
        $this->response = $container->get('app\core\Response');
        $this->controller = $container->get('app\core\Controller');
        $this->router = $router;
        $this->router->setContainer($this->container);
        session_start();
    }

    public function run()
    {
        echo $this->router->resolve();
    }

    public function getDatabase() {
        return $this->database;
    }

    public function LoggedIn() {
        $response = $this->container->get(Response::class);

        $session_id = $response->getCookie('session_id');

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
            $this->controller->redirect('/logout');
            return false;
        }
        return true;

    }

    public function getUser() {
        $session_id = $this->response->getCookie('session_id');
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

    public function getContainer()
    {
        return $this->container;
    }

}