<?php

namespace App\Controllers;

use App\Abstractions\Controller;
use App\Lib\Sessao;
use App\Models\DAO\FilialDAO;
use App\Models\Entidades\Filial;

class FilialController extends Controller
{
    public function index(): void
    {
        $filialDAO = new FilialDAO();

        self::setViewParam('filial', $filialDAO->listar());

        $this->render('filial/index');
    }

    public function edicao(): void
    {
        $filialDAO = new FilialDAO();

        self::setViewParam('filial', $filialDAO->getDadosfilial($_GET['id']));

        $this->render('filial/editar');
    }

    public function cadastro(): void
    {
        $filialDAO = new FilialDAO();

        self::setViewParam('filial', $filialDAO->listar());

        $this->render('filial/cadastrar');
    }

    public function cadastrar(): void
    {
        $filial = new Filial([
            'id' => intval($_POST['id']),
            'numero' => intval(substr($_POST['idFilial'], -3)),
            'empresa' => 1,
            'cidade' => strval($_POST['cidade']),
            'uf' => strval($_POST['uf']),        
        ]);

        $filialDAO = new FilialDAO();

        try {
            $filialDAO->cadastrar($filial);

            Sessao::gravaSucesso("Nova filial cadastrada com sucesso!");
            $this->redirect('filial', 'index');
        } catch (\Exception $e) {
            Sessao::gravaErro("Erro ao cadastrar nova filial. Contate o suporte.");
            $this->redirect('filial', 'cadastro');
        }
    }

    public function editar(): void
    {
        $filial = new Filial(
            $this->getDadosFilial()
        );

        $filialDAO = new FilialDAO();

        try {
            $filialDAO->editar($filial);

            Sessao::gravaSucesso("Filail editada com sucesso!");
        } catch (\Exception $e) {
            Sessao::gravaErro("Erro ao editar filial. Contate o suporte.");
        }

        $this->redirect('filial', "edicao?id={$filial->getId()}");
    }

    private function getDadosFilial(): array
    {
        return [
            'id' => intval($_POST['id']),
            'numero' => intval(substr($_POST['idFilial'], -3)),
            'empresa' => 1,
            'cidade' => strval($_POST['cidade']),
            'uf' => strval($_POST['uf']), 
        ];
    }

    public function deletar(): void
    {
        $id = $_GET['id'];
        $filialDAO = new filialDAO();

        try {
            $filialDAO->deletar($id);

            Sessao::gravaSucesso("filial removida com sucesso!");
        } catch (\Exception $e) {
            Sessao::gravaErro("Erro ao remover filial.");
        }

        $this->redirect('filial', "index");
    }
}
