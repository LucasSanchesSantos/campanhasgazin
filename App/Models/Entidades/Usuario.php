<?php

namespace App\Models\Entidades;

use App\Abstractions\Entity;

class Usuario extends Entity
{
    protected int $id;
    protected int $idFilial;
    protected int $numeroFilial;
    protected int $idEmpresa;
    protected string $cidade;
    protected string $usuario;
    protected string $senha;
    protected int $idTipoFormato;
    protected int $idTipoPermissao;
    protected ?string $caminhoImagem;
    protected ?string $telefone;

    public function __construct(array $usuario)
    {
        $this->setId($usuario['id']);
        $this->setIdFilial($usuario['idFilial']);
        $this->setNumeroFilial($usuario['numeroFilial']);
        $this->setIdEmpresa($usuario['idEmpresa']);
        $this->setCidade($usuario['cidade']);
        $this->setUsuario($usuario['usuario']);
        $this->setSenha($usuario['senha']);
        $this->setIdTipoFormato($usuario['idTipoFormato']);
        $this->setIdTipoPermissao($usuario['idTipoPermissao']);
        $this->setCaminhoImagem($usuario['caminho_imagem']);
        $this->setTelefone($usuario['telefone']);

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

    public function getIdFilial(): int
    {
        return $this->idFilial;
    }

    private function setIdFilial(int $idFilial): self
    {
        $this->idFilial = $idFilial;

        return $this;
    }

    public function getNumeroFilial(): int
    {
        return $this->numeroFilial;
    }

    private function setNumeroFilial(int $numeroFilial): self
    {
        $this->numeroFilial = $numeroFilial;

        return $this;
    }

    public function getIdEmpresa(): int
    {
        return $this->idEmpresa;
    }

    private function setIdEmpresa(int $idEmpresa): self
    {
        $this->idEmpresa = $idEmpresa;

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

    public function getUsuario(): string
    {
        return $this->usuario;
    }

    private function setUsuario(string $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getSenha(): string
    {
        return $this->senha;
    }

    private function setSenha(string $senha): self
    {
        $this->senha = $senha;

        return $this;
    }

    public function getIdTipoFormato(): int
    {
        return $this->idTipoFormato;
    }

    public function setIdTipoFormato(int $idTipoFormato): self
    {
        $this->idTipoFormato = $idTipoFormato;

        return $this;
    }

    public function getIdTipoPermissao(): int
    {
        return $this->idTipoPermissao;
    }

    private function setIdTipoPermissao(int $idTipoPermissao): self
    {
        $this->idTipoPermissao = $idTipoPermissao;

        return $this;
    }

    public function getCaminhoImagem(): ?string
    {
        return $this->caminhoImagem;
    }

    private function setCaminhoImagem(?string $caminhoImagem): self
    {
        $this->caminhoImagem = $caminhoImagem;

        return $this;
    }

    public function getTelefone(): ?string
    {
        return $this->telefone;
    }

    private function setTelefone(?string $telefone): self
    {
        $this->telefone = $telefone;

        return $this;
    }
}
