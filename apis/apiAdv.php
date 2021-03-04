  
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

        if(count($res) > 0){
                $result = json_encode(array('success'=>true, 'result'=>$dados));


            }else{
                $result = json_encode(array('success'=>false, 'msg'=>'Dados Incorretos!'));

            }
            echo $result;

}





else if($postjson['requisicao'] == 'listar_dados'){

$cpf_adv = $postjson['cpf'];

$res_c = $pdo->query("SELECT * from clientes where advogado = '$cpf_adv'");
$dados_c = $res_c->fetchAll(PDO::FETCH_ASSOC);
$total_clientes = count($dados_c);

$res_p = $pdo->query("SELECT * from processos where advogado = '$cpf_adv'");
$dados_p = $res_p->fetchAll(PDO::FETCH_ASSOC);
$total_processos = count($dados_p);

$res_a = $pdo->query("SELECT * from audiencias where advogado = '$cpf_adv'");
$dados_a = $res_a->fetchAll(PDO::FETCH_ASSOC);
$total_aud = count($dados_a);


$res_t = $pdo->query("SELECT * from tarefas where advogado = '$cpf_adv' and data >= curDate()");
$dados_t = $res_t->fetchAll(PDO::FETCH_ASSOC);
$total_tarefas = count($dados_t);  
  
  $dados = array(
    'clientes' => $total_clientes,
    'processos' =>  @$total_processos,
   'audiencias' => $total_aud,
   'tarefas' => $total_tarefas,
            
  );
     
  
          if($dados){
                  $result = json_encode(array('success'=>true, 'result'=>$dados));
  
              }else{
                  $result = json_encode(array('success'=>false, 'result'=>'0'));
  
              }
              echo $result;
  
  }







?>