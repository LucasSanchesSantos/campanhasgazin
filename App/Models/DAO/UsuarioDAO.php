<?php

namespace App\Models\DAO;

use App\Abstractions\DAO;
use App\Models\Entidades\Usuario;

class UsuarioDAO extends DAO
{
    public function getUsuarios(): ?array
    {
        $sql = $this->getSqlDadosUsuarios();

        $resultado = $this->selectWithBindValue($sql);

        if (!$resultado) {
            return null;
        }

        return $resultado;
    }

    public function getDadosUsuario(int $id): ?array
    {
        $sql = $this->getSqlDadosUsuario();

        $parametro = [
            'id' => $id
        ];

        $resultado = $this->selectOneWithBindValue($sql, $parametro);

        if (!$resultado) {
            return null;
        }

        return $resultado;
    }


    
    public function cadastrar(Usuario $usuario): bool
    {
        $parametros = $usuario->toArray(true);

        return $this->insert(
            'usuario',
            $parametros
        );
    }

    public function editar(Usuario $usuario): bool
    {
        $parametros = $usuario->toArray(true, ['id']);

        return $this->update(
            'usuario',
            $parametros,
            "id = {$usuario->getId()}"
        );
    }

    public function getFiliaisUsuarios(): array
    {
        $sql = $this->getSqlFiliaisUsuarios();

        $resultado = $this->select($sql);

        if (!$resultado) {
            return null;
        }

        return $resultado;
    }

    private function getSqlDadosUsuario(): string
    {
        return "SELECT
                u.*
                ,CONCAT(f.numero,' - ',f.cidade) as filial
            FROM
                usuario u
                left join filial f on f.id = u.id_filial
            WHERE
                u.id = :id";
    }

    private function getSqlDadosUsuarios(): string
    {
        return "SELECT
            u.id,
            u.id_filial,
            u.numero_filial,
            u.id_empresa,
            u.cidade,
            u.usuario,
            tp.descricao AS tipo_formato,
            tp2.descricao AS tipo_permissao,
            CONCAT(f.numero,' - ',f.cidade) as filial
        FROM
            usuario u
            INNER JOIN tipo_formato tp ON tp.id = u.id_tipo_formato
            INNER JOIN tipo_permissao tp2 ON tp2.id = u.id_tipo_permissao 
            left join filial f on f.id = u.id_filial";
    }

    private function getSqlFiliaisUsuarios(): string
    {
        return "SELECT
            DISTINCT(id_filial)
        FROM
            usuario";
    }

    public function deletar($usuario)
    {        
        return $this->delete(
            'usuario',
            'id',
            $usuario    
        );
    }

    


}
