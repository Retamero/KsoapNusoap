<?php
	require_once 'lib/nusoap.php';

	$client = new nusoap_client('http://retamero.com.br/webservice/server.php?wsdl');
	$resultado = $client->call('exemplo', array('id'=>'1'));

	//echo utf8_encode($resultado);
	echo "<h1>Recebido do Webservice</h1>";
	echo  $resultado;

	$obj = json_decode($resultado);

	// decodifica as instruções do json e guarda a array na variavel "obj"
	echo "<h1>Suas anota&ccedil;&otilde;es</h1>";
	echo "<hr></hr>";
	echo "<b>Id: </b>". $obj->aluno_id . "<br>";
	echo "<b>Peso: </b>" . $obj->peso . "<br>";
	echo "<b>Altura: </b>" . $obj->altura . "<br>";
	echo "<b>Peitoral Maior: </b>" . $obj->peitoral_maior . "<br>";
	echo "<b>Peitoral Menor: </b>" . $obj->peitoral_menor . "<br>";
	echo "<b>Quadril: </b>" . $obj->quadril . "<br>";
	echo "<b>Biceps Esquerdo: </b>" . $obj->biceps_esquerdo . "<br>";
	echo "<b>Biceps Direito: </b>" . $obj->biceps_direito . "<br>";
	echo "<b>Triceps Esquerdo: </b>" . $obj->triceps_esquerdo . "<br>";
	echo "<b>Triceps Direito: </b>" . $obj->triceps_direito . "<br>";
	echo "<b>Coxa Esquerda: </b>" . $obj->coxas_esquerda . "<br>";
	echo "<b>Coxa Direita: </b>" . $obj->coxas_direita . "<br>";
	echo "<b>Panturrilha Esquerda: </b>" . $obj->panturrilha_esquerda . "<br>";
	echo "<b>Panturrilha Direita: </b>" . $obj->panturrilha_direita . "<br>";
	echo "<b>Quadril Esquerdo: </b>" . $obj->quadril_esquerdo . "<br>";
	echo "<b>Quadril Direito: </b>" . $obj->quadril_direito . "<br>";
	echo "<hr></hr>";
?>
