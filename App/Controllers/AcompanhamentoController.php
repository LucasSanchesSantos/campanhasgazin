<?php

namespace App\Controllers;

use App\Abstractions\Controller;
use App\Models\DAO\AcompanhamentoDAO;
use Exception;

class AcompanhamentoController extends Controller
{
    public function index(): void
    {
        $acompanhamentoDAO = new AcompanhamentoDAO();

        self::setViewParam('acompanhamento', $acompanhamentoDAO->listar());

        $this->render('acompanhamento/index');
    }

}
