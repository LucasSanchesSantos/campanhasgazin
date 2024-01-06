<?php

namespace App\Lib;

class Sessao
{
    private static function gravar(
        string $primeiroIndex,
        string $segundoIndex = '',
        mixed $valor
    ): void
    {
        self::ativarSessao();

        if (empty($segundoIndex)) {
            $_SESSION[$primeiroIndex] = $valor;
        }

        if(!empty($segundoIndex)) {
            $_SESSION[$primeiroIndex][$segundoIndex] = $valor;
        }
    }

    public static function ativarSessao() {
        $isSessaoAtiva = session_status() === PHP_SESSION_ACTIVE;

        if (!$isSessaoAtiva) {
            session_start();
        }
    }

    public static function gravaSucesso($mensagem)
    {
        self::gravar('sucesso', '', $mensagem);
    }

    public static function retornaSucesso()
    {
        self::ativarSessao();
        
        $mensagem = !empty($_SESSION['sucesso']) ? $_SESSION['sucesso'] : "";

        unset($_SESSION['sucesso']);

        return $mensagem;
    }

    public static function gravaErro($mensagem)
    {
        self::gravar('erro', '', $mensagem);
    }

    public static function retornaErro()
    {
        self::ativarSessao();

        $erro = !empty($_SESSION['erro']) ? $_SESSION['erro'] : "";

        unset($_SESSION['erro']);

        return $erro;
    }

    public static function gravaUsuario(array $usuario): void
    {
        self::gravar('usuario', '', $usuario);
    }

    public static function getUsuario(): ?array
    {
        self::ativarSessao();

        return $_SESSION['usuario'];
    }

    public static function setUsuarioIdFilialSelecionada(int $idFilialSelecionada): void
    {
        self::gravar('usuario', 'id_filial_selecionada', $idFilialSelecionada);
    }
}
