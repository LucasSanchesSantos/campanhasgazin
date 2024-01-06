<?php

namespace App\Controllers;

use App\Abstractions\Controller;
use App\Lib\Sessao;
use App\Models\Constants\TipoPermissao;
use App\Models\DAO\FilialDAO;
use App\Models\DAO\TipoFormatoDAO;
use App\Models\DAO\TipoPermissaoDAO;
use App\Models\DAO\UsuarioDAO;
use App\Models\Entidades\Usuario;

class UsuarioController extends Controller
{
    public function index(): void
    {
        $usuarioDAO = new UsuarioDAO();

        self::setViewParam('usuarios', $usuarioDAO->getUsuarios());

        $this->render('usuario/index');
        
    }

    public function edicao(): void
    {
        $usuarioLogado = Sessao::getUsuario();

        $idUsuario = !empty($_GET['id']) && $usuarioLogado['id_tipo_permissao'] == TipoPermissao::ADMINISTRATIVO->value ?
            intval($_GET['id']) : Sessao::getUsuario()['id'];

        $usuarioDAO = new UsuarioDAO();
        $tipoFormatoDAO = new TipoFormatoDAO();
        $tipoPermissaoDAO = new TipoPermissaoDAO();
        $filiais = new FilialDAO();

        self::setViewParam('usuario', $usuarioDAO->getDadosUsuario($idUsuario));
        self::setViewParam('tiposFormato', $tipoFormatoDAO->listar());
        self::setViewParam('tiposPermissao', $tipoPermissaoDAO->listar());
        self::setViewParam('filiais', $filiais->listar());

        $this->render('usuario/editar');
    }

    public function cadastro(): void
    {
        $tipoFormatoDAO = new TipoFormatoDAO();
        $tipoPermissaoDAO = new TipoPermissaoDAO();
        $filiais = new FilialDAO();

        self::setViewParam('tiposFormato', $tipoFormatoDAO->listar());
        self::setViewParam('tiposPermissao', $tipoPermissaoDAO->listar());
        self::setViewParam('filiais', $filiais->listar());

        $this->render('usuario/cadastrar');
    }

    public function cadastrar(): void
    {
        $usuario = new Usuario([
            'id' => 0,
            'idFilial' => intval($_POST['idFilial']),
            'numeroFilial' => intval(substr($_POST['idFilial'], -3)),
            'idEmpresa' => 1,
            'cidade' => 1,
            'usuario' => strval($_POST['usuario']),
            'senha' => password_hash(strval($_POST['senha']), PASSWORD_DEFAULT),
            'idTipoFormato' => 1,
            'idTipoPermissao' => intval($_POST['idTipoPermissao'])
        ]);

        $usuarioDAO = new UsuarioDAO();

        try {
            $usuarioDAO->cadastrar($usuario);

            Sessao::gravaSucesso("Usuário cadastrado com sucesso!");
        } catch (\Exception $e) {
            Sessao::gravaErro("Erro ao cadastrar usuário.");
        }

        $this->redirect('usuario', 'index');
    }

    public function editar(): void
    {
        $usuario = new Usuario(
            $this->getDadosUsuario()
        );

        $usuarioDAO = new UsuarioDAO();

        try {
            $usuarioDAO->editar($usuario);

            Sessao::gravaSucesso("Usuário editado com sucesso!");
        } catch (\Exception $e) {
            Sessao::gravaErro("Erro ao editar usuário.");
        }

        $this->redirect('usuario', "index");
    }

    private function getDadosUsuario(): array
    {
        $usuarioLogado = Sessao::getUsuario();

        if (!empty($_POST['id']) && $usuarioLogado['id_tipo_permissao'] == TipoPermissao::ADMINISTRATIVO->value) {
            $arquivo = $_FILES['imagem'];

            $caminhoImagem = "";

            if($arquivo['error']){
                $usuarioDAO = new UsuarioDAO();

                $dadosUsuario = $usuarioDAO->getDadosUsuario($_POST['id']);
                $caminhoImagem = $dadosUsuario['caminho_imagem'];

            }else{
                $nomeDoArquivo = $arquivo['name'];
                $novoNomeDoArquivo = uniqid();
                $extensao = strtolower(pathinfo($nomeDoArquivo,PATHINFO_EXTENSION));
        
                $path = 'App/Views/Imagens/Colaboradores/';
                $caminhoImagem = $path . $novoNomeDoArquivo . "." . $extensao;
        
                move_uploaded_file($arquivo['tmp_name'],$path . $novoNomeDoArquivo . "." . $extensao);
            }

            return [
                'id' => intval($_POST['id']),
                'idFilial' => intval($_POST['idFilial']),
                'numeroFilial' => intval(substr($_POST['idFilial'], -3)),
                'idEmpresa' => 1,
                'cidade' => 1,
                'usuario' => strval($_POST['usuario']),
                'senha' => $this->getSenha(intval($_POST['id'])),
                'idTipoFormato' => 1,
                'idTipoPermissao' => intval($_POST['idTipoPermissao']),
                'caminho_imagem' => strval($caminhoImagem)
            ];
        }

        return [
            'id' => intval($usuarioLogado['id']),
            'idFilial' => intval($usuarioLogado['id_filial']),
            'numeroFilial' => intval(substr($_POST['idFilial'], -3)),
            'idEmpresa' => 1,
            'cidade' => 1,
            'usuario' => strval($usuarioLogado['usuario']),
            'senha' => $this->getSenha(intval($usuarioLogado['id'])),
            'idTipoFormato' => 1,
            'idTipoPermissao' => intval($usuarioLogado['id_tipo_permissao'])
        ];
    }

    private function getSenha(int $idUsuario): string {
        if (!empty($_POST['senha'])) {
            return password_hash(strval($_POST['senha']), PASSWORD_DEFAULT);
        }

        $usuarioDAO = new UsuarioDAO();
        
        return $usuarioDAO->getDadosUsuario($idUsuario)['senha'];
    }

    public function deletar(): void
    {
        $id = $_GET['id'];
        $usuarioDAO = new UsuarioDAO();

        try {
            $usuarioDAO->deletar($id);

            Sessao::gravaSucesso("Usuário removido com sucesso!");
        } catch (\Exception $e) {
            Sessao::gravaErro("Erro ao remover usuário.");
        }

        $this->redirect('usuario', "index");
    }
}
