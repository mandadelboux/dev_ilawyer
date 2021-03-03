<?php 

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With'); 
header('Content-Type: application/json; charset=utf-8');  


// dados do banco no servidor local
$banco = 'dev_bd_adv';
$host = '127.0.0.1';
$usuario = 'root';
$senha = '';


//dados do banco no servidor hospedado
// $banco = 'hugocu75_ionic';
// $host = 'br534.hostgator.com.br';
// $usuario = 'hugocu75_ionic';
// $senha = 'testeionic';


try {

	$pdo = new PDO("mysql:dbname=$banco;host=$host", "$usuario", "$senha");
	
} catch (Exception $e) {
	echo 'Erro ao conectar com o banco!! '. $e;
}

 ?>