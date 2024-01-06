<?php

namespace App\Models\Entidades;

use App\Abstractions\Entity;

class Filial extends Entity
{
    protected int $id;
    protected int $numero;
    protected int $empresa;
    protected string $cidade;
    protected string $uf;


    public function __construct(array $filial)
    {
        $this->setId($filial['id']);
        $this->setNumero($filial['numero']);
        $this->setEmpresa($filial['empresa']);
        $this->setCidade($filial['cidade']);
        $this->setUf($filial['uf']);

    }

    public function getId(): int
    {
        return $this->id;
    }

    private function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getNumero(): int
    {
        return $this->numero;
    }

    private function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getEmpresa(): int
    {
        return $this->empresa;
    }

    private function setEmpresa(int $empresa): self
    {
        $this->empresa = $empresa;

        return $this;
    }

    public function getCidade(): string
    {
        return $this->cidade;
    }

    private function setCidade(string $cidade): self
    {
        $this->cidade = $cidade;

        return $this;
    }

    public function getUf(): string
    {
        return $this->uf;
    }

    private function setUf(string $uf): self
    {
        $this->uf = $uf;

        return $this;
    }
    
}
