<?php
function loadClass($nomeClasse){
    $arquivo = __DIR__.'/class/'.$nomeClasse.'.php';
    //COMANDO PARA NÃO HAVER PROBLEMAS COM BARRAS NO SISTEMA OPERACIONAL LINUX
    $caminhoCompleto = str_replace('\\',DIRECTORY_SEPARATOR,$arquivo);
    if(is_file($caminhoCompleto)){
        require_once($caminhoCompleto);
    }
}

spl_autoload_register('loadClass');

