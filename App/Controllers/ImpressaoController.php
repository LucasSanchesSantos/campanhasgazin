<?php

namespace App\Controllers;

use App\Abstractions\Controller;
use App\Lib\Sessao;
use App\Models\Constants\TipoPermissao;
use App\Models\Constants\TipoPromocao;
use App\Models\DAO\ImpressaoDAO;
use App\Models\DAO\ImpressaoPersonalizadaDAO;
use App\Models\DAO\ProdutoDAO;
use Exception;

class ImpressaoController extends Controller
{
    public function index(): void
    {
        $usuarioLogado = Sessao::getUsuario();

        if (
            !empty($_GET['idFilialSelecionada'])
            && $usuarioLogado['id_tipo_permissao'] == TipoPermissao::ADMINISTRATIVO->value
        ) {
            Sessao::setUsuarioIdFilialSelecionada(intval($_GET['idFilialSelecionada']));
        }

        $idFilialSelecionada = Sessao::getUsuario()['id_filial_selecionada'];

        $impressaoDAO = new ImpressaoDAO();
        $impressaoPersonalizadaDAO = new ImpressaoPersonalizadaDAO();

        self::setViewParam('tiposCartazes', $impressaoPersonalizadaDAO->getTiposCartazes());
        self::setViewParam('filiais', $impressaoDAO->getFiliais2());
        self::setViewParam('promocoes', $impressaoDAO->getPromocoes($idFilialSelecionada));
        self::setViewParam('categorias', $impressaoDAO->getCategorias());
        self::setViewParam('subcategorias', $impressaoDAO->getSubcategorias());
        self::setViewParam('idProdutos', $impressaoDAO->getIdProdutos());

        $this->render('impressao/index');
    }

    public function cartazes(): void
    {
        $this->render('impressao/a4');
    }

    public function produtosPorFiltro(): void
    {
        try {
            $idFilial = $_GET['idFilial'] ?: null;
            $promocao = $_GET['promocao'] ?: null;
            $idPromocao = $_GET['id_promocao'] ?: null;

            $descricaoPromocao = null;
            $tipoPromocao = null;

            if (!empty($promocao)) {
                $promocao = explode('|', $promocao);

                $descricaoPromocao = $promocao[0];
                $tipoPromocao = $promocao[1];
            }

            $idDepartamento = $_GET['idDepartamento'] ?: null;
            $idSubdepartamento = $_GET['idSubdepartamento'] ?: null;
            $idProduto = $_GET['idProduto'] ?: null;

            $filtros = [
                'idFilial' => intval($idFilial),
                'idFilial2' => intval($idFilial),
                'id_promocao' => is_null($idPromocao) ? null : strval($idPromocao),
                'id_promocao2' => is_null($idPromocao) ? null : strval($idPromocao),
                'tipoPromocao' => is_null($tipoPromocao) ? null : strval($tipoPromocao),
                'idDepartamento' => is_null($idDepartamento) ? null : intval($idDepartamento),
                'idSubdepartamento' => is_null($idSubdepartamento) ? null : intval($idSubdepartamento),
                'idProduto' => is_null($idProduto) ? null : intval($idProduto),
                'idProduto2' => is_null($idProduto) ? null : intval($idProduto),
                'validacaoFiltroPromocao' =>  intval($_GET['validacaoFiltroPromocao'])
            ];

            $produtosComPromocoesAgrupadas = $this->getProdutosComPromocoesAgrupadas($filtros);

            if (empty($produtosComPromocoesAgrupadas)) {
                http_response_code(404);

                echo 'Nenhum produto encontrado!';

                return;
            }

            http_response_code(200);

            echo json_encode($produtosComPromocoesAgrupadas);
        } catch (Exception $e) {
            http_response_code($e->getCode());

            echo 'Erro ao obter dados.';
        }
    }

    private function getProdutosComPromocoesAgrupadas($filtros): ?array
    {
        $produtoDAO = new ProdutoDAO();

        $produtos = $produtoDAO->getProdutosPorFiltros($filtros);

        if (empty($produtos)) {
            return null;
        }

        $produtosComMelhorCondicao = $this->getProdutosComMelhorCondicao($produtos);

        $produtoPromocoes = $this->getProdutoPromocoes($produtos);

        foreach ($produtosComMelhorCondicao as $idProdutoCompleto => &$produto) {
            $produto['promocoes'] = $produtoPromocoes[$idProdutoCompleto]['promocoes'];
        }

        return $this->getProdutosComPrecoAVista($produtosComMelhorCondicao);
    }

    private function getProdutosComMelhorCondicao(array $produtos): array
    {
        $produtosSemDuplicatas = $this->getProdutosSemDuplicatas($produtos);

        $produtosComMelhorCondicao = [];

        foreach ($produtosSemDuplicatas as $produto) {
            $idProduto = $produto['id_produto'];
            $idGradeX = $produto['id_grade_x'];
            $idGradeY = $produto['id_grade_y'];
            $idProdutoCompleto = "{$idProduto}.{$idGradeX}.{$idGradeY}";

            $promocoesTipoCarteira = array_filter(
                $produtos,
                function (array $produto) use ($idProduto, $idGradeX, $idGradeY) {
                    return $produto['id_produto'] === $idProduto
                        && $produto['id_grade_x'] === $idGradeX
                        && $produto['id_grade_y'] === $idGradeY
                        && $produto['tipo'] === TipoPromocao::CARTEIRA->value;
                }
            );

            if (!empty($promocoesTipoCarteira)) {
                $produtoMelhorCondicao = array_shift($promocoesTipoCarteira);

                foreach ($promocoesTipoCarteira as $promocaoTipoCarteira) {
                    if ($promocaoTipoCarteira['preco_a_prazo'] < $produtoMelhorCondicao['preco_a_prazo']) {
                        $produtoMelhorCondicao = $promocaoTipoCarteira;
                    }
                }

                $produtosComMelhorCondicao[$idProdutoCompleto] = $produtoMelhorCondicao;

                continue;
            }

            $promocoesNaoTipoCarteira = array_filter(
                $produtos,
                function (array $produto) use ($idProduto, $idGradeX, $idGradeY) {
                    return $produto['id_produto'] === $idProduto
                        && $produto['id_grade_x'] === $idGradeX
                        && $produto['id_grade_y'] === $idGradeY
                        && $produto['tipo'] !== TipoPromocao::CARTEIRA->value;
                }
            );

            $produtoMelhorCondicao = array_shift($promocoesNaoTipoCarteira);

            foreach ($promocoesNaoTipoCarteira as $promocaoNaoTipoCarteira) {
                if ($promocaoNaoTipoCarteira['preco_a_prazo'] < $produtoMelhorCondicao['preco_a_prazo']) {
                    $produtoMelhorCondicao = $promocaoNaoTipoCarteira;
                }
            }

            $produtosComMelhorCondicao[$idProdutoCompleto] = $produtoMelhorCondicao;

            continue;

            $produtosComMelhorCondicao[$idProdutoCompleto] = $produto;
        }

        return $produtosComMelhorCondicao;
    }

    private function getProdutosSemDuplicatas(array $produtos): array
    {
        $produtosSemDuplicatas = [];

        foreach ($produtos as $produto) {
            $idProduto = $produto['id_produto'];
            $idGradeX = $produto['id_grade_x'];
            $idGradeY = $produto['id_grade_y'];
            $idProdutoCompleto = "{$idProduto}.{$idGradeX}.{$idGradeY}";

            $produtosSemDuplicatas[$idProdutoCompleto] = $produto;
        }

        return $produtosSemDuplicatas;
    }

    private function getProdutoPromocoes(array $produtos): array
    {
        $produtoPromocoes = [];

        foreach ($produtos as $produto) {
            $idProduto = $produto['id_produto'];
            $idGradeX = $produto['id_grade_x'];
            $idGradeY = $produto['id_grade_y'];
            $idProdutoCompleto = "{$idProduto}.{$idGradeX}.{$idGradeY}";

            $produtoPromocoes[$idProdutoCompleto]['promocoes'][] = [
                'id_promocao_produto_grade' => $produto['id_promocao_produto_grade'],
                'promocao' => $produto['promocao'],
                'tipo' => $produto['tipo'],
                'valor' => $produto['tipo'] === TipoPromocao::A_VISTA->value ? $produto['preco_partida'] : $produto['preco_a_prazo'],
                'prazo_inicial' => $produto['prazo_inicial'],
                'prazo_final' => $produto['prazo_final']
            ];
        }

        return $produtoPromocoes;
    }

    private function getProdutosComPrecoAVista(array $produtos): array
    {
        foreach ($produtos as &$produto) {
            if ($produto['tipo'] === TipoPromocao::A_VISTA->value) {
                $produto['preco_a_vista'] = $produto['preco_a_prazo'];

                continue;
            }

            $produto['preco_a_vista'] = 0;
        }

        return $produtos;
    }
}
