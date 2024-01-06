<?php

namespace App\Abstractions;

use App\Lib\Conexao;
use Exception;
use PDO;

abstract class DAO
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = Conexao::getConnection();
    }

    public function select(string $sql): bool|array
    {
        if (!empty($sql)) {
            $statement = $this->conexao->prepare($sql);
            
            $statement->execute();
            
            return $statement->fetchAll(PDO::FETCH_COLUMN);
        }
    }

    public function selectWithBindValue(string $sql, array $params = [], ): bool|array
    {
        if (!empty($sql)) {
            $statement = $this->conexao->prepare($sql);

            foreach ($params as $key => $param) {
                $statement->bindValue(":{$key}", $param);
            }
            
            $statement->execute();
            
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function selectOneWithBindValue(string $sql, array $params = []): bool|array
    {
        if (!empty($sql)) {
            $statement = $this->conexao->prepare($sql);

            foreach ($params as $key => $param) {
                $statement->bindValue($key, $param);
            }

            $statement->execute();
            
            return $statement->fetch(PDO::FETCH_ASSOC);
        }
    }

    public function insert(string $table, array $parameters): int
    {
        try {
            if (!empty($table) && !empty($parameters)) {
                $columns = '';
                $binds = '';

                foreach ($parameters as $index => $value) {
                    $columns .= "{$index}, ";
                    $binds .= ":{$index}, ";
                }

                $columns = substr($columns, 0, -2);
                $binds = substr($binds, 0, -2);

                $stmt = $this->conexao->prepare("INSERT INTO $table ($columns) VALUES ($binds)");

                $stmt->execute($parameters);

                return $this->conexao->lastInsertId();
            }
        } catch (Exception $e) {
            throw new Exception("Erro na gravação de dados. {$e->getMessage()}", 500);
        }
    }

    public function upsert(string $table, array $parameters): int
    {
        try {
            if (!empty($table) && !empty($parameters)) {
                $columns = '';
                $binds = '';
                $clause = '';
                
                foreach ($parameters as $index => $value) {
                    $columns .= "{$index}, ";
                    $binds .= ":{$index}, ";
                    $clause .= "{$index} = :{$index}_update, ";

                    $parameters["{$index}_update"] = $value;
                }

                $columns = substr($columns, 0, -2);
                $binds = substr($binds, 0, -2);
                $clause = substr($clause, 0, -2);

                $stmt = $this->conexao->prepare(
                    "INSERT INTO {$table} ({$columns}) VALUES ({$binds}) ON DUPLICATE KEY UPDATE {$clause}"
                );

                $stmt->execute($parameters);

                return $this->conexao->lastInsertId();
            }
        } catch (Exception $e) {
            throw new Exception("Erro na gravação de dados. {$e->getMessage()}", 500);
        }
    }

    public function update(string $table, array $parameters, ?string $where = null)
    {
        if (!empty($table) && !empty($parameters)) {
            if ($where) {
                $where = "WHERE $where ";
            }

            $clause = '';

            foreach($parameters as $index => $value) {
                if (gettype($value) === 'string') {
                    $clause .= "{$index} = '{$value}', ";

                    continue;
                }

                $clause .= "{$index} = {$value}, ";
            }

            $clause = substr($clause, 0, -2);

            $stmt = $this->conexao->prepare("UPDATE {$table} SET {$clause} {$where}");
            $stmt->execute();

            return $stmt->rowCount();
        } else {
            return false;
        }
    }

    public function delete($table, $pk, $id)
    {
        if (!empty($table)) {
            $stmt = $this->conexao->prepare("DELETE FROM $table WHERE $pk = {$id}");
            $stmt->execute();

            return $stmt->rowCount();
        } else {
            return false;
        }
    }
}
