<?php

namespace App\Abstractions;

use App\Lib\Sessao;
use App\Models\Constants\TipoPermissao;

abstract class Controller
{
    protected $app;
    private $viewVar;

    public function __construct($app)
    {
        $this->setViewParam('nameController', $app->getControllerName());
        $this->setViewParam('nameAction', $app->getAction());
    }

    public function render($view)
    {
        $viewVar = $this->getViewVar();
        $usuario = Sessao::getUsuario();
        $sucesso = Sessao::retornaSucesso();
        $erro = Sessao::retornaErro();
        $isAdministrativo = TipoPermissao::ADMINISTRATIVO->value == $usuario['id_tipo_permissao'];
        
        if ($view === 'login/index') {
            require_once PATH . '/App/Views/Componentes/Cabecalho.php';
            require_once PATH . '/App/Views/' . $view . '.php';
            require_once PATH . '/App/Views/Componentes/Rodape.php';

            return;
        }

        require_once PATH . '/App/Views/Componentes/Cabecalho.php';
        require_once PATH . '/App/Views/Componentes/Menu.php';

        if ($this->possuiPermissaoParaEssaView($view, $isAdministrativo)) {
            require_once PATH . '/App/Views/' . $view . '.php';
        } else {
            require_once PATH . '/App/Views/inicio/index.php';
        }


        require_once PATH . '/App/Views/Componentes/Rodape.php';
    }

    public function redirect(string $controller, string $view): void
    {
        header("Location:" . URL . "{$controller}/{$view}");
    }

    public function getViewVar()
    {
        return $this->viewVar;
    }

    public function setViewParam($varName, $varValue)
    {
        if ($varName != "" && $varValue != "") {
            $this->viewVar[$varName] = $varValue;
        }
    }

    public function limpaCaracteres($valor)
    {
        $chars = array(".", "/", "-", "*", "(", ")", " ");

        return str_replace($chars, "", $valor);
    }

    private function possuiPermissaoParaEssaView(string $view, bool $isAdministrativo): bool
    {
        if (in_array($view, $this->viewsAdministrativo())){
            return $isAdministrativo;
        }

        return true;
    }

    private function viewsAdministrativo(): array
    {
        return [
            'usuario/index',
            'usuario/cadastro',
            'tipoPagamento/index'
        ];
    }
}
