<?php
	$host='';
	
	include('library/template.php');

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		$dataIn = json_decode(file_get_contents('php://input'), true);
		if( isset($dataIn['url']) && isset($dataIn['tipo'])&& isset($dataIn['parametros'])){
			$url = $dataIn['url'];
			$tipo = $dataIn['tipo'];
			$parametros = $dataIn['parametros'];

			$jsonData=json_encode($parametros);
			sendPOST($url,$jsonData);
			
		}else{
			$arr = array('estado' => '404', 'mensaje' => 'faltan parametros en request');
			echo json_encode($arr);	
		}
	}else{
		$arr = array('estado' => '404', 'mensaje' => 'Metodo REST incorrecto');
		echo json_encode($arr);
	}



function sendPOST($url,$jsonData){
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	curl_close($ch);
	echo $result;
}
?>