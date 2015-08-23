<?php
	$id = $_POST["ident"];
	$peso = $_POST["peso"];
	$altura = $_POST["altura"];
	$peitoral_maior = $_POST["peitoral_maior"];
	$peitoral_menor = $_POST["peitoral_menor"];
	$quadril = $_POST["quadril"];
	$biceps_esquerdo = $_POST["biceps_esquerdo"];
	$biceps_direito = $_POST["biceps_direito"];
	$triceps_esquerdo = $_POST["triceps_esquerdo"];
	$triceps_direito = $_POST["triceps_direito"];
	$coxas_esquerda = $_POST["coxas_esquerda"];
	$coxas_direita = $_POST["coxas_direita"];
	$panturrilha_esquerda = $_POST["panturrilha_esquerda"];
	$panturrilha_direita = $_POST["panturrilha_direita"];
	$quadril_esquerdo = $_POST["quadril_esquerdo"];
	$quadril_direito = $_POST["quadril_direito"];

	echo "<pre>" . $id . "<br>";
	echo $peso . "<br>";
	echo $altura . "<br>";
	echo $peitoral_maior . "<br>";
	echo $peitoral_menor . "<br>";
	echo $quadril . "<br>";
	echo $biceps_esquerdo . "<br>";
	echo $biceps_direito . "<br>";
	echo $triceps_esquerdo . "<br>";
	echo $triceps_direito . "<br>";
	echo $coxas_esquerda . "<br>";
	echo $coxas_direita . "<br>";
	echo $panturrilha_esquerda . "<br>";
	echo $panturrilha_direita . "<br>";
	echo $quadril_esquerdo . "<br>";
	echo $quadril_direito . "<br>";


		require_once 'lib/nusoap.php';
		$vetor = array(
		"id"=>$_POST["ident"],
		"peso"=>$_POST["peso"],
		"altura"=>$_POST["altura"],
		"peitoral_maior"=>$_POST["peitoral_maior"],
		"peitoral_menor"=>$_POST["peitoral_menor"],
		"quadril"=>$_POST["quadril"],
		"biceps_esquerdo"=>$_POST["biceps_esquerdo"],
		"biceps_direito"=>$_POST["biceps_direito"],
		"triceps_esquerdo"=>$_POST["triceps_esquerdo"],
		"triceps_direito"=>$_POST["triceps_direito"],
		"coxas_esquerda"=>$_POST["coxas_esquerda"],
		"coxas_direita"=>$_POST["coxas_direita"],
		"panturrilha_esquerda"=>$_POST["panturrilha_esquerda"],
		"panturrilha_direita"=>$_POST["panturrilha_direita"],
		"quadril_esquerdo"=>$_POST["quadril_esquerdo"],
		"quadril_direito"=>$_POST["quadril_direito"]
		);

		$json=json_encode($vetor);
		echo "VETOR CONVERIDO:" .$json;
		$cliente = new nusoap_client('http://retamero.com.br/webservice/server.php?wsdl');
		$resultado = $cliente->call('update',array('id'=>$id, 'json'=>$json));

		//echo utf8_encode($resultado);
		echo "<h1>Recebido do Webservice</h1>";
		echo  $resultado;
		echo "<form action=\"client.php\" method=\"post\">";
		echo "id: <input type=\"text\" name=\"ident\"><br>";
		echo "<input type=\"submit\">";
		echo "</form>";


?>
