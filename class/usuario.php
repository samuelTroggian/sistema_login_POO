<?php
require_once('Crud.php');

class Usuario extends Crud{
    protected string $tabela = 'usuario1';
    public $nome;
    private $email;
    private $senha;
    private $repete_senha;
    private $recupera_senha;
    private $token;
    private $codigo_confirmacao;
    private $status;
    public $erro;

    public function __construct(
        string $nome,
        string $email, 
        string $senha, 
        string $repete_senha="", 
        string $recupera_senha="", 
        string $token="", 
        string $codigo_confirmacao="",
        string $status="",
        array $erro=[]){
            $this->nome = $nome;
            $this->email = $email;
            $this->senha = $senha;
            $this->repete_senha = $repete_senha;
            $this->recupera_senha = $recupera_senha;
            $this->token = $token;
            $this->codigo_confirmacao = $codigo_confirmacao;
            $this->status = $status;
            $this->erro = $erro;
    }

    public function set_repeticao($repete_senha){
        $this->repete_senha = $repete_senha;
    }

    public function validar_cadastro(){
        //VALIDAR NOME
        if (!preg_match("/^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ'\s]+$/",$this->nome)) {
            $this->erro["erro_nome"] = ["Por favor informe um nome válido!"];
        }

        //VERIFICAR SE EMAIL É VÁLIDO
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->erro['erro_email'] = "Formato de e-mail inválido!";
        }

        if(strlen($this->senha < 6)){
            $this->erro['erro_senha'] = "Deve conter 6 caracteres ou mais!";
        }

        if($this->senha !== $this->repete_senha){
            $this->erro['erro_repete_senha'] = "Valores de senha e repetição de senha diferentes!";
        }
    }

    public function insert(){
        //VERIFICAR SE ESTE EMAIL JÁ ESTÁ CADASTRADO NO BANCO
        $sql = "SELECT * FROM $this->tabela WHERE email=? LIMIT 1";
        $sql = DB::prepare($sql);
        $sql->execute(array($this->email));
        $usuario = $sql->fetch();
        //SE NÃO EXISTIR O USUARIO - ADICIONAR NO BANCO
        if (!$usuario){
            $data_cadastro = date('d/m/Y');
            $senha_cripto = sha1($this->senha);
            $sql = "INSERT INTO $this->tabela VALUES (null,?,?,?,?,?,?,?,?)";
            $sql = DB::prepare($sql);
            return $sql->execute(array($this->nome,$this->email,$senha_cripto,$this->recupera_senha,$this->token,$this->codigo_confirmacao,$this->status,$data_cadastro));
        }else{
            $this->erro["erro_geral"] = "Usuário já cadastrado!";
        }
    }

    public function update($id){
        $sql = "UPDATE $this->tabela SET token=? WHERE id=?";
        $sql = DB::prepare($sql);
        return $sql->execute([$token, $id]);
    }
}