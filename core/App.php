<?php

class App
{
    protected $controller = 'AuthController';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();

        // Vérifie si le contrôleur existe
        if (isset($url[0])) {
            $controllerName = ucfirst($url[0]) . 'Controller';
            $controllerPath = '../app/controllers/' . $controllerName . '.php';

            if (file_exists($controllerPath)) {
                $this->controller = $controllerName;
                unset($url[0]);
            }
        }

        // Inclut le contrôleur
        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // Vérifie si la méthode existe
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // Récupère les éventuels paramètres
        $this->params = $url ? array_values($url) : [];

        // Appelle le contrôleur et sa méthode avec les paramètres
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    // Analyse l'URL et la découpe
    private function parseUrl()
    {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}
