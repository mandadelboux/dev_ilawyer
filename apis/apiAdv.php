<?php

include_once('conexao.php');

$postjson = json_decode(file_get_contents('php://input'), true);


if($postjson['requisicao'] == 'login'){

    $senha = md5($postjson['senha']);    
    $query = $pdo->query("SELECT * from usuarios where usuario = '$postjson[usuario]' and senha = '$senha'");
    
    $res = $query->fetchAll(PDO::FETCH_ASSOC);

   for ($i=0; $i < count($res); $i++) { 
      foreach ($res[$i] as $key => $value) {
      }
     $nivel = $res[$i]['nivel'];
     $dados = array(
       'id' => $res[$i]['id'],
       'nome' => $res[$i]['nome'],
       'usuario' => $res[$i]['usuario'],
            'senha' => $res[$i]['senha'],
            'cpf' => $res[$i]['cpf'],
            'nivel' => $res[$i]['nivel'],
            
        
    );
  }
}