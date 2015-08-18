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
// para sobecrever se a variavel estiver em branco.
$POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';
// devolve para o clinte
$server->service($POST_DATA);
exit();

?>