<?php
require_once('../class/config.php');
require_once('../loadClass.php');

$login=new Login();
$login->isAuth($_SESSION['TOKEN']);

echo "<h1>Bem-Vindo $login->nome!<br>Email: $login->email";