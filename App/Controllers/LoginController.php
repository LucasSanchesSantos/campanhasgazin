<?php

namespace App\Controllers;

use App\Abstractions\Controller;
use App\Lib\Sessao;
use App\Models\DAO\LoginDAO;

class LoginController extends Controller
{
    public function index(): void
    {
        $this->render('login/index');
    }

    public function logar(): void
    {
        $login = strval($_POST['login']);
        $senha = strval($_POST['senha']);

        $loginDAO = new LoginDAO();

        $usuario = $loginDAO->getUsuario($login);

        if (
            !$usuario
            || !password_verify($senha, $usuario['senha'])
        ) {
            Sessao::gravaErro('Login ou senha incorreto. Tente novamente!');

            $this->redirect('login', 'index');

            return;
        }

        Sessao::gravaUsuario($usuario);

        $this->redirect('inicio', 'index');
    }

    public function logout(): void
    {
        session_destroy();
        
        $this->redirect('login', 'index');
    }
}
