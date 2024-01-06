<?php

namespace App\Models\DAO;

use App\Abstractions\DAO;

class TipoFormatoDAO extends DAO
{
    public function listar(): ?array
    {
        $sql = $this->getSqlListarTiposFormato();

        $resultado = $this->selectWithBindValue($sql);

        if (!$resultado) {
            return null;
        }

        return $resultado;
    }

    private function getSqlListarTiposFormato(): string
    {
        return "SELECT
                *
            FROM
                tipo_formato";
    }
}
