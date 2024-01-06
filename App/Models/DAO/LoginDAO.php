<?php

namespace App\Models\DAO;

use App\Abstractions\DAO;

class LoginDAO extends DAO
{
    public function getUsuario(string $usuario): ?array
    {
        $sql = $this->getSqlDadosUsuario();

        $parametro = [
            'usuario' => $usuario
        ];

        $resultado = $this->selectOneWithBindValue($sql, $parametro);

        if (!$resultado) {
            return null;
        }

        return $resultado;
    }

    private function getSqlDadosUsuario(): string
    {
        return "SELECT
                *,
                u.id_filial AS id_filial_selecionada
            FROM
                usuario u
            WHERE
                u.usuario = :usuario";
    }
}
