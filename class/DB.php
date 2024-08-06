<?php
require_once('config.php');

class DB{
    private static $pdo;
    //FUNÇÃO PARA INSTANCIAR O BANCO DE DADOS
    public static function instanciar(){
        //SE NÃO EXISTE CONEXÃO COM O BANCO - CONECTA
        if(!isset(self::$pdo)){
            try{
                self::$pdo = new PDO("mysql:host=".SERVIDOR.";dbname=".BANCO, USUARIO, SENHA);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            }catch(PDOException $erro){
                echo "Falha ao se conectar com o banco: ". $erro->getMessage();
            }
        }
        //SE EXISTE CONEXÃO COM O BANCO - RETORNA CONECTADO.
        return self::$pdo;
    }

    public static function prepare($sql){
        return self::instanciar()->prepare($sql);
    }

}