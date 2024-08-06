<?php
session_start();
//CONFIGURAÇÕES DO BANCO DE DADOS
define('SERVIDOR','localhost');
define('USUARIO','root');
define('SENHA','@Qualidade22');
define('BANCO','login');

function limpaPost($dados){
    $dados = trim($dados);
    $dados = htmlspecialchars($dados);
    $dados = stripslashes($dados);
    return $dados;
}

?>