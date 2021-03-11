<?php

include_once('conexao.php');

$postjson = json_decode(file_get_contents('php://input'), true);


if($postjson['requisicao'] == 'add-mov'){

   		
$titulo = $postjson['titulo'];
$data = $postjson['data'];
$obs = $postjson['obs'];
$processo = $postjson['processo'];



	$res = $pdo->prepare("INSERT into historico (titulo, obs, data, processo) values (:titulo, :obs, :data, :processo)");

	$res->bindValue(":titulo", $titulo);
	$res->bindValue(":obs", $obs);
	$res->bindValue(":data", $data);
	$res->bindValue(":processo", $processo);
	
	

	$res->execute();

		
  
    $id = $pdo->lastInsertId();


       
  
      if($query){
        $result = json_encode(array('success'=>true, 'id'=>$id));
  
        }else{
        $result = json_encode(array('success'=>false));
    
        }
     echo $result;





    
}else if($postjson['requisicao'] == 'listar'){

    
      
      
      $cpf_adv = $postjson['cpf_adv'];
      $busca = '%'. $postjson['nome'] . '%';
      $query = $pdo->query("SELECT * from processos where (num_processo LIKE '$busca' or cliente LIKE '$busca') and advogado = '$cpf_adv' order by id desc limit $postjson[start], $postjson[limit]");
   


    $res = $query->fetchAll(PDO::FETCH_ASSOC);

 	for ($i=0; $i < count($res); $i++) { 
      foreach ($res[$i] as $key => $value) {
      }

      		$tipo_acao = $res[$i]['tipo_acao'];
      		$cliente = $res[$i]['cliente'];
      		$vara = $res[$i]['vara'];
      		$data = $res[$i]['data_audiencia'];

      		$data2 = implode('-', array_reverse(explode('-', $data)));

      		$res_tipo = $pdo->query("SELECT * from especialidades where id = '$tipo_acao'");
			$dados_tipo = $res_tipo->fetchAll(PDO::FETCH_ASSOC);
			$linhas_tipo = count($dados_tipo);
			$nome_tipo = $dados_tipo[0]['nome'];


			$res_cli = $pdo->query("SELECT * from clientes where cpf = '$cliente'");
			$dados_cli = $res_cli->fetchAll(PDO::FETCH_ASSOC);
			$linhas_cli = count($dados_cli);
			$nome_cli = $dados_cli[0]['nome'];


			$res_vara = $pdo->query("SELECT * from varas where id = '$vara'");
			$dados_vara = $res_vara->fetchAll(PDO::FETCH_ASSOC);
			$linhas_vara = count($dados_vara);
			$nome_vara = $dados_vara[0]['nome'];



 		$dados[] = array(
 			'id' => $res[$i]['id'],
 			'processo' => $res[$i]['num_processo'],
 			'vara' => $nome_vara,
			'acao' => $nome_tipo,
            'cliente' => $nome_cli,
            'obs' => $res[$i]['obs'],
            'data_audiencia' => $data2,
            'audiencias' => $res[$i]['audiencias'],
            'status' => $res[$i]['status'],
            
        
 		);

 }

        if(count($res) > 0){
                $result = json_encode(array('success'=>true, 'result'=>$dados));

            }else{
                $result = json_encode(array('success'=>false, 'result'=>'0'));

            }
            echo $result;

}






elseif($postjson['requisicao'] == 'editar'){
    

$id = $postjson['id'];
$nome = $postjson['nome'];
$cpf = $postjson['cpf'];
$telefone = $postjson['telefone'];
$email = $postjson['email'];
$endereco = $postjson['endereco'];
$obs = $postjson['obs'];
$pessoa = $postjson['pessoa'];

$cpf_limpo = preg_replace('/[^0-9]/', '', $cpf);
$cpf_cript = md5($cpf_limpo);




$res = $pdo->prepare("UPDATE clientes set nome = :nome, telefone = :telefone, email = :email, endereco = :endereco, obs = :obs, tipo_pessoa = :tipo_pessoa where id = :id ");

$res->bindValue(":nome", $nome);
//$res->bindValue(":cpf", $cpf);
$res->bindValue(":telefone", $telefone);
$res->bindValue(":email", $email);
$res->bindValue(":endereco", $endereco);
$res->bindValue(":obs", $obs);
$res->bindValue(":tipo_pessoa", $pessoa);
$res->bindValue(":id", $id);


$res->execute();


	
	$res = $pdo->prepare("UPDATE usuarios set nome = :nome,  usuario = :usuario where cpf = :cpf ");

	$res->bindValue(":nome", $nome);
	$res->bindValue(":usuario", $email);
	
	$res->bindValue(":cpf", $cpf);

	$res->execute();
	
       $id = $pdo->lastInsertId();
       
  
      if($query){
        $result = json_encode(array('success'=>true, 'id'=>$id));
  
        }else{
        $result = json_encode(array('success'=>false));
    
        }
     echo $result;

    }





elseif($postjson['requisicao'] == 'excluir'){
    
 $id = $postjson['id'];           
       
//BUSCAR O EMAIL DO REGISTRO PARA TAMBÉM DELETAR NA TABELA DE FUNCIONÁRIOS
$res_excluir = $pdo->query("select * from clientes where id = '$id'");
$dados_excluir = $res_excluir->fetchAll(PDO::FETCH_ASSOC);
$cpf= $dados_excluir[0]['cpf'];
$cargo= $dados_excluir[0]['cargo'];


//EXCLUIR NA TABELA DE USUÁRIOS
$pdo->query("DELETE from usuarios where cpf = '$cpf' ");


$res = $pdo->query("DELETE from clientes where id = '$id' ");

                 
      
          if($query){
            $result = json_encode(array('success'=>true));
      
            }else{
            $result = json_encode(array('success'=>false));
        
            }
         echo $result;
    
        }





else if($postjson['requisicao'] == 'listar-mov'){

    
      
      
      $cpf_adv = $postjson['cpf_adv'];
      
    if($postjson['dataBuscar'] == ''){
	$query = $pdo->query("SELECT * from historico where data = curDate() order by id desc");
	}else{
	$txtbuscar = $postjson['dataBuscar'];
	$txtbuscar2 = '%'.$postjson['nome'].'%';
	$query = $pdo->query("SELECT * from historico where data = '$txtbuscar' and processo LIKE '$txtbuscar2' order by id desc");

	}
   


    $res = $query->fetchAll(PDO::FETCH_ASSOC);

 	for ($i=0; $i < count($res); $i++) { 
      foreach ($res[$i] as $key => $value) {
      }

      		
      		$data = $res[$i]['data'];

      		$data2 = implode('-', array_reverse(explode('-', $data)));

      		


 		$dados[] = array(
 			'id' => $res[$i]['id'],
 			'processo' => $res[$i]['processo'],
 			'data' => $data2,
			'titulo' => $res[$i]['titulo'],
            
            'obs' => $res[$i]['obs'],
           
            
        
 		);

 }

        if(count($res) > 0){
                $result = json_encode(array('success'=>true, 'result'=>$dados));

            }else{
                $result = json_encode(array('success'=>false, 'result'=>'0'));

            }
            echo $result;

}






elseif($postjson['requisicao'] == 'editar-mov'){
    

$id = $postjson['id'];
$titulo = $postjson['titulo'];
$obs = $postjson['obs'];
$data = $postjson['data'];




$res = $pdo->prepare("UPDATE historico set titulo = :titulo, obs = :obs, data = :data where id = '$id' ");

	$res->bindValue(":titulo", $titulo);
	$res->bindValue(":obs", $obs);
	$res->bindValue(":data", $data);
	
	

	$res->execute();


	
	
       $id = $pdo->lastInsertId();
       
  
      if($query){
        $result = json_encode(array('success'=>true, 'id'=>$id));
  
        }else{
        $result = json_encode(array('success'=>false));
    
        }
     echo $result;

    }




elseif($postjson['requisicao'] == 'excluir-mov'){
    
 $id = $postjson['id'];           
       

$res = $pdo->query("DELETE from historico where id = '$id' ");

                 
      
          if($query){
            $result = json_encode(array('success'=>true));
      
            }else{
            $result = json_encode(array('success'=>false));
        
            }
         echo $result;
    
        }




?>