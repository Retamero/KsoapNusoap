<?php
        require_once('lib/nusoap.php');
        $server = new nusoap_server();
        $server->configureWSDL('server.exemplo', 'urn:server');
        $server->wsdl->schemaTargetNamespace = 'urn:server';

        $server->register('exemplo', 
                        array('id'=>'xsd:string'),
                        array('return'=>'xsd:string'),
                        'urn:server',
                 'urn:server#exemplo',
                 'rpc',
                 'encoded',
                'Apenas um exemplo utilizando o NuSOAP PHP.'
);

        $server->register('update', 
			array('id'=>'xsd:string',
			'json'=>'xsd:string'),
                        array('return'=>'xsd:string'),
                        'urn:server',
                 'urn:server#update',
                 'rpc',
                 'encoded',
                'Apenas um exemplo utilizando o NuSOAP PHP.'
);


        function exemplo($id){
                $conecta = mysql_connect("localhost", "retamero_root", "Mudar123") or print (mysql_error());
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
                $conecta = mysql_connect("localhost", "seuuser", "suasenha") or print (mysql_error());
                mysql_select_db("suatabela", $conecta) or print(mysql_error());
                $sql = "UPDATE medidas SET (
                'peso',
                'altura',
                'peitoral_maior',
                'peitoral_menor',
                'quadril',
                'biceps_esquerdo',
                'biceps_direito',
                'triceps_esquerdo',
                'triceps_direito',
                'coxas_esquerda',
                'coxas_direita',
                'panturrilha_esquerda',
                'panturrilha_direita',
                'quadril_esquerdo',
                'quadril_direito'
                )VALUES(
                '".$decodificado['peso']."',
                '".$decodificado['peitoral_maior']."',
                '".$decodificado['peitoral_menor']."',
                '".$decodificado['quadril']."',
                '".$decodificado['biceps_esquerdo']."',
                '".$decodificado['biceps_direito']."',
                '".$decodificado['triceps_esquerdo']."',
                '".$decodificado['triceps_direito']."',
                '".$decodificado['coxas_esquerda']."',
                '".$decodificado['coxas_direita']."',
                '".$decodificado['panturrilha_esquerda']."',
                '".$decodificado['panturrilha_direita']."',
                '".$decodificado['quadril_esquerdo']."',
                '".$decodificado['quadril_direito']."'
                ) WHERE aluno_id = " . $id;
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
// para sobecrever se a variavel estiver em branco.
$POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';
// devolve para o clinte
$server->service($POST_DATA);
exit();

?>
