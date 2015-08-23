<?php
	$id = $_POST["ident"];

	if($id !=""){	
	require_once 'lib/nusoap.php';

	$cliente = new nusoap_client('http://retamero.com.br/webservice/server.php?wsdl');
	$resultado = $cliente->call('exemplo',array('id'=>$id));

	//echo utf8_encode($resultado);
	echo "<h1>Recebido do Webservice</h1>";
	echo  $resultado;

	$obj = json_decode($resultado);

	// decodifica as instruções do json e guarda a array na variavel "obj"

	echo "<h1>Suas anota&ccedil;&otilde;es</h1>";
	echo "<hr></hr>";
	echo "<b>Id: </b>". $obj->id . "<br>";
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

	echo "<form action=\"clientUpdate.php\" method=\"post\">";
	//echo "id: <input type=\"text\" name=\"ident\" value=". $obj->id ." disabled><br>";
	echo "id: <input type=\"text\" name=\"ident\" value=". $obj->id ."><br>";
	echo "Peso: <input type=\"text\" name=\"peso\" value=". $obj->peso ."><br>";
	echo "Altura: <input type=\"text\" name=\"altura\" value=". $obj->altura ."><br>";
	echo "Peitoral Maior: <input type=\"text\" name=\"peitoral_maior\" value=". $obj->peitoral_maior ."><br>";
	echo "Peitoral Menor: <input type=\"text\" name=\"peitoral_menor\" value=". $obj->peitoral_menor ."><br>";
	echo "Quadril: <input type=\"text\" name=\"quadril\" value=". $obj->quadril ."><br>";
	echo "Biceps Esquerdo: <input type=\"text\" name=\"biceps_esquerdo\" value=". $obj->biceps_esquerdo ."><br>";
	echo "Biceps Direto: <input type=\"text\" name=\"biceps_direito\" value=". $obj->biceps_direito ."><br>";
	echo "Tripces Esquerdo: <input type=\"text\" name=\"triceps_esquerdo\" value=". $obj->triceps_esquerdo ."><br>";
	echo "Tripces Direito: <input type=\"text\" name=\"triceps_direito\" value=". $obj->triceps_direito ."><br>";
	echo "Coxa Esquerda: <input type=\"text\" name=\"coxas_esquerda\" value=". $obj->coxas_esquerda ."><br>";
	echo "Coxa Direita: <input type=\"text\" name=\"coxas_direita\" value=". $obj->coxas_direita ."><br>";
	echo "anturrilha Esquerda: <input type=\"text\" name=\"panturrilha_esquerda\" value=". $obj->panturrilha_esquerda ."><br>";
	echo "Panturrilha Direita: <input type=\"text\" name=\"panturrilha_direita\" value=". $obj->panturrilha_direita ."><br>";
	echo "Quadril Esquerdo: <input type=\"text\" name=\"quadril_esquerdo\" value=". $obj->quadril_esquerdo ."><br>";
	echo "Quadril Direito: <input type=\"text\" name=\"quadril_direito\" value=". $obj->quadril_direito ."><br>";
	echo "<input type=\"submit\" value=\"Editar\">";
	echo "</form>";

}else{
	echo "<form action=\"client.php\" method=\"post\">";
	echo "id: <input type=\"text\" name=\"ident\"><br>";
	echo "<input type=\"submit\">";
	echo "</form>";
}

?>
