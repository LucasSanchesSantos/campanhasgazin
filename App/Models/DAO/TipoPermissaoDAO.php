<?php

namespace App\Models\DAO;

use App\Abstractions\DAO;

class TipoPermissaoDAO extends DAO
{
    public function listar(): ?array
    {
        $sql = $this->getSqlListarTiposPermissao();

        $resultado = $this->selectWithBindValue($sql);

        if (!$resultado) {
            return null;
        }

        return $resultado;
    }

    private function getSqlListarTiposPermissao(): string
    {
        return "SELECT
                *
            FROM
                tipo_permissao";
    }
}
