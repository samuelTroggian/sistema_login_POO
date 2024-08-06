<?php
require_once('DB.php');

class Login{
    protected $tabela = 'usuario1';
    public $email;
    private $senha;
    public $nome;
    private $token;
    public $erro=[];

    public function auth($email, $senha){
        //CRIPTOGRAFAR A SENHA
        $senha_cripto = sha1($senha);

        //VERIFICAR SE TEM ESTE USUARIO CADASTRADO
        $sql = "SELECT * FROM $this->tabela WHERE email=? AND senha=? LIMIT 1";
        $sql = DB::prepare($sql);
        $sql->execute([$email, $senha_cripto]);
        $usuario = $sql->fetch(PDO::FETCH_ASSOC);
        if($usuario){
            //CRIAR UM TOKEN
            $this->token = sha1(uniqid().date('d-m-Y-H-i-s'));
            //ATUALIZAR ESTE TOKEN NO BANCO
            $sql = "UPDATE $this->tabela SET token=? WHERE email=? AND senha=? LIMIT 1";
            $sql = DB::prepare($sql);
            if($sql->execute([$this->token, $email, $senha_cripto])){
                //COLOCAR O TOKEN NA SESSAO
                $_SESSION['TOKEN']=$this->token;
                //REDIRECIONAMOS NOSSO USUARIO PARA AREA RESTRITA
                header('location:restrita/index.php');
            }else{
                $this->erro['erro_geral']="Falha ao se comunicar com servidor!";
            }

        }else{
            $this->erro['erro_geral'] = "Usuário ou senha incorreto!";
        }
    }

    public function isAuth($token){
        $sql = "SELECT * FROM $this->tabela WHERE token=?";
        $sql = DB::prepare($sql);
        $sql->execute([$token]);
        $usuario = $sql->fetch(PDO::FETCH_ASSOC);
        if($usuario){
            $this->nome = $usuario['nome'];
            $this->email = $usuario['email'];
        }else{
            header('location:../index.php');
        }
    }
}

