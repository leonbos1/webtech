<?php


namespace app\core;

class View
{
    public function renderView($view, array $params)
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        $layoutName = Application::$app->layout;
        if (Application::$container->get(Controller::class)) {
            $layoutName = Application::$container->get(Controller::class)->layout;
        }

        $viewContent = $this->renderViewOnly($view, $params);
        ob_start();
        include_once Application::$root_directory."/views/layouts/$layoutName.php";
        $layoutContent = ob_get_clean();

        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    public function renderViewOnly($view, array $params)
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once Application::$root_directory."/views/$view.php";
        return ob_get_clean();
    }
}