<?php

namespace App;

use App\Lib\Sessao;
use Exception;

class App
{
    private $controller;
    private $controllerFile;
    private $action;
    private $params;
    public $controllerName;

    public function __construct()
    {
        define('APP_HOST', "{$_ENV['PROTOCOL_SSL']}{$_SERVER['HTTP_HOST']}/App/");
        define('URL', "{$_ENV['PROTOCOL_SSL']}{$_SERVER['HTTP_HOST']}/");
        define('URI', $_SERVER['REQUEST_URI']);

        define('PATH', realpath('./'));
        define('PATH_USERS_IMG', "{$_ENV['PROTOCOL_SSL']}{$_SERVER['HTTP_HOST']}/");
        define('PATH_IMG', "{$_ENV['PROTOCOL_SSL']}{$_SERVER['HTTP_HOST']}/App/Views/Imagens/");
        define('PATH_JS', "{$_ENV['PROTOCOL_SSL']}{$_SERVER['HTTP_HOST']}/App/Views/JavaScript/");
        define('PATH_LOG', realpath('./') . '/log/');

        define('TITLE', "Cartazeando - Gestão de Cartazes");

        define('DB_HOST', $_ENV['DB_HOST']);
        define('DB_USER', $_ENV['DB_USER']);
        define('DB_PASSWORD', $_ENV['DB_PASSWORD']);
        define('DB_NAME', $_ENV['DB_NAME']);
        define('DB_DRIVER', $_ENV['DB_DRIVER']);

        $this->url();
    }

    public function run()
    {
        if (
            $this->controller
            && !empty(Sessao::getUsuario())
            && strtolower($this->controller) != 'login'
            || (strtolower($this->controller) == 'login' && strtolower($this->action) == 'logout')
        ) {
            $this->controllerName = ucwords($this->controller) . 'Controller';
            $this->controllerName = preg_replace('/[^a-zA-Z]/i', '', $this->controllerName);
        } else if (
            (!$this->controller || strtolower($this->controller) == 'login')
            && !empty(Sessao::getUsuario()))
        {
            $this->controllerName = "InicioController";
        } else {
            $this->controllerName = "LoginController";
        }

        $this->controllerFile = $this->controllerName . '.php';
        $this->action = preg_replace('/[^a-zA-Z]/i', '', $this->action ?? '');

        if (!file_exists(PATH . '/App/Controllers/' . $this->controllerFile)) {
            throw new Exception("Página não encontrada.", 404);
        }

        $nomeClasse = "\\App\\Controllers\\" . $this->controllerName;
        $objetoController = new $nomeClasse($this);

        if (!class_exists($nomeClasse)) {
            throw new Exception("Erro na aplicação", 500);
        }

        if (method_exists($objetoController, $this->action)) {
            $objetoController->{$this->action}($this->params);
            return;
        } else if (!$this->action && method_exists($objetoController, 'index')) {
            $objetoController->index($this->params);
            return;
        } else {
            throw new Exception("Aguardo. Nosso suporte já esta verificando!", 500);
        }

        throw new Exception("Página não encontrada.", 404);
    }

    public function url()
    {
        if (isset($_GET['url'])) {

            $path = $_GET['url'];
            $path = substr($path, 1);
            $path = rtrim($path, '/');
            $path = filter_var($path, FILTER_SANITIZE_URL);

            $path = explode('/', $path);

            $this->controller = $this->verificaArray($path, 0);
            $this->action = $this->verificaArray($path, 1);

            if ($this->verificaArray($path, 2)) {
                unset($path[0]);
                unset($path[1]);
                $this->params = array_values($path);
            }
        }
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getControllerName()
    {
        return $this->controllerName;
    }

    private function verificaArray($array, $key)
    {
        if (isset($array[$key]) && !empty($array[$key])) {
            return $array[$key];
        }
        return null;
    }
}
