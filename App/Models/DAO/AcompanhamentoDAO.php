<?php

namespace App\Models\DAO;

use App\Abstractions\DAO;

class AcompanhamentoDAO extends DAO
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
            tb.campanha_ref
            ,tb.idfilial
            ,tb.filial
            ,tb.caminho_imagem
            ,tb.ouro
            ,tb.prata
            ,tb.bronze
            ,tb.score
            ,@rank := @rank + 1 AS colocacao
        from (
            select 
                tb.campanha_ref
                ,tb.idfilial
                ,CONCAT(LPAD(f.empresa,2,'0'),'.',LPAD(f.numero ,3,'0'),' - ',f.cidade) as filial
                ,u.caminho_imagem
                ,tb.ouro
                ,tb.prata
                ,tb.bronze
                ,COALESCE((tb.ouro * pm.pontos_por_medalha) + (tb.prata * pm.pontos_por_medalha) + (tb.bronze * pm.pontos_por_medalha),0) as score
            from (
                SELECT 
                    rm.campanha_ref
                    ,rm.idfilial
                    ,rm.tipo_medalha
                    ,COALESCE(
                        CASE 
                            WHEN rm.tipo_medalha = 'Ouro' THEN rm.quantidade_medalhas
                            ELSE 0 
                        END,
                        0
                    ) AS ouro
                    ,COALESCE(
                        CASE 
                            WHEN rm.tipo_medalha = 'Prata' THEN rm.quantidade_medalhas
                            ELSE 0 
                        END,
                        0
                    ) AS prata
                    ,COALESCE(
                        CASE 
                            WHEN rm.tipo_medalha = 'Bronze' THEN rm.quantidade_medalhas
                            ELSE 0 
                        END,
                        0
                    ) AS bronze
                FROM registro_medalhas rm
            ) tb
            LEFT JOIN parametro_pontos_por_medalha pm ON pm.tipo_medalha = tb.tipo_medalha
                                                        AND pm.campanha_ref = tb.campanha_ref
            left join usuario u on u.id_tipo_permissao = 2 and u.id_filial = tb.idfilial
            left join filial f on f.id = tb.idfilial
        ) tb
        JOIN (SELECT @rank := 0) r
        order by score desc, ouro desc, prata desc, bronze desc
        
        ";
    }
}
