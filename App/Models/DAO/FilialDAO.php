<?php

namespace App\Models\DAO;

use App\Abstractions\DAO;
use App\Models\Entidades\Filial;

class FilialDAO extends DAO
{
    public function listar(): ?array
    {
        $sql = $this->getSqlListarFilial();

        $resultado = $this->selectWithBindValue($sql);

        if (!$resultado) {
            return null;
        }

        return $resultado;
    }

    private function getSqlListarFilial(): string
    {
        return "SELECT
                *
                ,id as id_filial
                ,CONCAT(numero,' - ',cidade) as filial
            FROM
                filial order by id";
    }

    public function cadastrar(Filial $filial): bool
    {
        $parametros = $filial->toArray(true);

        return $this->insert(
            'filial',
            $parametros
        );
    }

    public function editar(Filial $filial): bool
    {
        $parametros = $filial->toArray(true, ['id']);

        return $this->update(
            'filial',
            $parametros,
            "id = {$filial->getId()}"
        );
    }


    public function getDadosFilial(int $id): ?array
    {
        $sql = $this->getSqlFilial();

        $parametro = [
            'id' => $id
        ];

        $resultado = $this->selectOneWithBindValue($sql, $parametro);

        if (!$resultado) {
            return null;
        }

        return $resultado;
    }

    private function getSqlFilial(): string
    {
        return "SELECT
                *
            FROM
                filial
            WHERE id = :id    
            ";
    }

    public function deletar($id)
    {        
        return $this->delete(
            'filial',
            'id',
            $id    
        );
    }

}
