<?php

include_once('conexao.php');

$postjson = json_decode(file_get_contents('php://input'), true);


if($postjson['requisicao'] == 'add'){

   		
$nome = $postjson['nome'];
$cpf = $postjson['cpf'];
$telefone = $postjson['telefone'];
$email = $postjson['email'];
$endereco = $postjson['endereco'];
$obs = $postjson['obs'];
$pessoa = $postjson['pessoa'];

$cpf_adv = $postjson['cpf_adv'];


$cpf_limpo = preg_replace('/[^0-9]/', '', $cpf);
$cpf_cript = md5($cpf_limpo);

//VERIFICAR SE O REGISTRO JÁ ESTÁ CADASTRADO
$res_c = $pdo->query("select * from clientes where cpf = '$cpf'");
$dados_c = $res_c->fetchAll(PDO::FETCH_ASSOC);
$linhas = count($dados_c);
if($linhas == 0){
	$res = $pdo->prepare("INSERT into clientes (nome, cpf, telefone, email, endereco, advogado, data, obs, tipo_pessoa) values (:nome, :cpf, :telefone, :email, :endereco, :advogado, curDate(), :obs, :tipo_pessoa) ");

	$res->bindValue(":nome", $nome);
	$res->bindValue(":cpf", $cpf);
	$res->bindValue(":telefone", $telefone);
	$res->bindValue(":email", $email);
	$res->bindValue(":endereco", $endereco);
	$res->bindValue(":advogado", $cpf_adv);
	
	$res->bindValue(":obs", $obs);
	$res->bindValue(":tipo_pessoa", $pessoa);

	$res->execute();


	

	$res = $pdo->prepare("INSERT into usuarios (nome, cpf, usuario, senha, senha_original, nivel) values (:nome, :cpf, :usuario, :senha, :senha_original, :nivel) ");

	$res->bindValue(":nome", $nome);
	$res->bindValue(":cpf", $cpf);
	$res->bindValue(":usuario", $email);
	$res->bindValue(":senha", $cpf_cript);
	$res->bindValue(":senha_original", $cpf_limpo);
	$res->bindValue(":nivel", 'Cliente');

	$res->execute();




	//CÓDIGO PARA DISPARAR EMAIL PARA O CLIENTE
	  $url_painel_cli = $url_sistema.'cliente';
	  $to = $email;    //enviar para o email do cliente
      $subject = "Você foi cadastrado no Sistema $nome_empresa";

      $message = "
      Seguem abaixo os dados para acesso ao sistema! <br> <br>
      Usuário - $email
      <br>
      Senha - $cpf_limpo
      
       
          <br><br><br> <i>Ver no seu painel do Cliente - <a title='$url_painel_cli' href='$url_painel_cli' target='_blank'>$url_painel_cli</a></i>
         
                      ";

          $remet = $email_site;
          $headers = 'MIME-Version: 1.0' . "\r\n";
          $headers .= 'Content-type: text/html; charset=utf-8;' . "\r\n";
          $headers .= "From: " .$remet;
          mail($to, $subject, $message, $headers);

	
  
    $id = $pdo->lastInsertId();


       
  
      if($query){
        $result = json_encode(array('success'=>true, 'id'=>$id));
  
        }else{
        $result = json_encode(array('success'=>false));
    
        }
     echo $result;


}


    
}else if($postjson['requisicao'] == 'listar'){

      $cpf_adv = $postjson['cpf_adv'];
      $busca = '%'. $postjson['nome'] . '%';
      $query = $pdo->query("SELECT * from clientes where (nome LIKE '$busca' or cpf LIKE '$busca') and advogado = '$cpf_adv' order by id desc limit $postjson[start], $postjson[limit]");
   


    $res = $query->fetchAll(PDO::FETCH_ASSOC);

 	for ($i=0; $i < count($res); $i++) { 
      foreach ($res[$i] as $key => $value) {
      }
 		$dados[] = array(
 			'id' => $res[$i]['id'],
 			'nome' => $res[$i]['nome'],
 			'cpf' => $res[$i]['cpf'],
			'email' => $res[$i]['email'],
            'telefone' => $res[$i]['telefone'],
            'endereco' => $res[$i]['endereco'],
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




?>