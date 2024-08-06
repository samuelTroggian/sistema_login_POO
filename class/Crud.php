<?php 
require_once('DB.php');

abstract class Crud extends DB{
    //PROPRIEDADE PROTEGITA COM ACESSO APENAS PARA AS CLASSES FILHAS
    protected string $tabela;
    //MÉDODOS PADRÃO PARA AS CLASSES FILHAS
    abstract public function insert();
    abstract public function update($id);

    function __construct(){
        $this->tabela = $tabela;
    }

    //FUNCTION PARA SELECIONAR O REGISTRO DE ID ESPECIFICADO NA EXECUÇÃO.
    public function find($id){
        $sql = "SELECT * FROM $this->tabela WHERE id=?";
        $sql = DB::prepare($sql);
        $sql->execute([$id]);
        $valor = $sql->fetch();
        return $valor;
    }
    //FUNCTION PARA SELECIONAR TODOS OS REGISTROS DA TABELA
    public function findAll(){
        $sql = "SELECT * FROM $this->tabela";
        $sql = DB::prepare($sql);
        $sql->execute([$id]);
        $valor = $sql->fetchAll();
        return $valor;
    }

    public function delete($id){
        $sql = "DELETE FROM $this->tabela WHERE id=?";
        $sql = DB::prepare($sql);
        return $sql->execute([$id]);
    }



}