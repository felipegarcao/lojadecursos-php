<?php
class Curso {

    private int $id;
    private string $nome;
    private string $descricao;
    private string $caminho_da_imagem;
    private string $data_cadastro;

    public function getId() : int
    {
        return $this->id;
    }

    public function setId(int $id) : void
    {
        $this->id = $id;
    }

    public function getNome() : string
    {
        return $this->nome;
    }

    public function setNome(string $nome) : void
    {
        $this->nome = $nome;
    }

    public function getDescricao() : string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao) : void
    {
        $this->descricao = $descricao;
    }

    public function getImagePath() : string
    {
        return $this->caminho_da_imagem;
    }
    
    public function setImagePath(string $caminho_da_imagem) : void
    {
        $this->caminho_da_imagem = $caminho_da_imagem;
    }

    public function getDataCadastro() : string {
        return $this->data_cadastro;
    }
    public function setDataCadastro($data_cadastro): void {
        $this->data_cadastro = $data_cadastro;
    }

}