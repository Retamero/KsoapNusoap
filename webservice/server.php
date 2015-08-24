<?php
        require_once('lib/nusoap.php');
        $server = new nusoap_server();
        $server->configureWSDL('server.exemplo', 'http://retamero.com.br/webservice');
        $server->wsdl->schemaTargetNamespace = 'http://retamero.com.br/webservice';

        $server->register('exemplo', 
                 array('id'=>'xsd:string'),
                 array('retorno'=>'xsd:string'),
                 'http://retamero.com.br/webservice',
                 'http://retamero.com.br/webservice/exemplo',
                 'rpc',
                 'encoded',
                'Apenas um exemplo utilizando o NuSOAP PHP.'
);

        $server->register('update', 
			array('id'=>'xsd:string',
			'json'=>'xsd:string'),
                 array('retorno'=>'xsd:string'),
                 'http://retamero.com.br/webservice',
                 'http://retamero.com.br/webservice/update',
                 'rpc',
                 'encoded',
                'Apenas um exemplo utilizando o NuSOAP PHP.'
);

        function exemplo($id){
                $conecta = mysql_connect("localhost", "user", "senha") or print (mysql_error());
                mysql_select_db("retamero_academia", $conecta) or print(mysql_error());
                $sql = "SELECT * FROM medidas WHERE aluno_id = " . $id ;
                $result = mysql_query($sql, $conecta);
                //while($consulta = mysql_fetch_array($result)) { //pega indice valor e nome do campo e valor
                while($consulta = mysql_fetch_assoc($result)) { // pega apenas nome do campo e valor
                        $retorno = json_encode($consulta);
                }
                mysql_free_result($result);
                mysql_close($conecta);
                if ($retorno == "")
                {
                	$retorno = "{\"id\":\"vazio\"}";
                }
                return $retorno;
        }
        
       function update($id, $json){
		$decodificado = json_decode($json, true);
      		
                $conecta = mysql_connect("localhost", "user", "senha") or print (mysql_error());
                mysql_select_db("retamero_academia", $conecta) or print(mysql_error());
                $sql = "UPDATE medidas SET
                peso = '".$decodificado['peso']."',
                altura = '".$decodificado['altura']."',
                peitoral_maior = '".$decodificado['peitoral_maior']."',
                peitoral_menor = '".$decodificado['peitoral_menor']."',
                quadril = '".$decodificado['quadril']."',
                biceps_esquerdo = '".$decodificado['biceps_esquerdo']."',
                biceps_direito = '".$decodificado['biceps_direito']."',
                triceps_esquerdo = '".$decodificado['triceps_esquerdo']."',
                triceps_direito = '".$decodificado['triceps_direito']."',
                coxas_esquerda = '".$decodificado['coxas_esquerda']."',
                coxas_direita = '".$decodificado['coxas_direita']."',
                panturrilha_esquerda = '".$decodificado['panturrilha_esquerda']."',
                panturrilha_direita = '".$decodificado['panturrilha_direita']."',
                quadril_esquerdo = '".$decodificado['quadril_esquerdo']."',
                quadril_direito = '".$decodificado['quadril_direito']."'                     
				WHERE id = " . $id ;
                $result = mysql_query($sql, $conecta);
               	$retorno = "{\"id\":\"ok\"}";
               	return $retorno;
        }
// para sobecrever se a variavel estiver em branco.
$POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';
// devolve para o clinte
$server->service($POST_DATA);
exit();

?>