<?php
	include('library/template.php');

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		$dataIn = json_decode(file_get_contents('php://input'), true);
		if( isset($dataIn['url']) && isset($dataIn['tipo'])&& isset($dataIn['parametros'])){
			$url = $dataIn['url'];
			$tipo =  $dataIn['tipo'];
			$parametros =  $dataIn["parametros"];


			switch ($url) {
				#Nacimiento
				case '/getNacimiento':
					getNacimiento($parametros);
					break;
				case '/setNacimiento':
					setNacimiento($parametros);
					break;
				#Matrimonio
				#Defuncion
				case '/getDefuncion':
					getDefuncion($parametros);
					break;
				case '/setDefuncion':
					setDefuncion($parametros);
					break;
				#Divorcio
				#DPI
				#Licencia
				case '/':
					# code...
					break;
				
				default:
					# code...
					break;
			}
			
		}else{
			$arr = array('estado' => '404', 'mensaje' => 'faltan parametros en request');
			echo json_encode($arr);	
		}
	}else{
		$arr = array('estado' => '404', 'mensaje' => 'Metodo REST incorrecto');
		echo json_encode($arr);
	}


#################### NACIMIENTO ############################
function getNacimiento($parametros){
	$url = 'http://35.232.40.193:9000/?';
	$url = $url.'dpiPadreMadre='.$parametros['dpiPadreMadre'];
	sendGET($url);
}

function setNacimiento($parametros){
	$url = 'http://35.232.40.193:9000';
	$data = array(
	    'dpiPadre' => $parametros['dpiPadre'],
	    'dpiMadre' => $parametros['dpiMadre'],
	    'apellido' => $parametros['apellido'],
	    'nombre' => $parametros['nombre'],
	    'fechaNacimiento' => $parametros['fechaNacimiento'],
	    'genero' => $parametros['genero'],
	    'departamento' => $parametros['departamento'],
	    'municipio' => $parametros['municipio']
	);
	$jsonData = json_encode($data);
	sendPOST($url,$jsonData);
}

#################### DEFUNCION ############################
function getDefuncion($parametros){
	$url = 'http://35.232.40.193:9002/?';
	$url = $url.'dpi='.$parametros['dpi'];
	sendGET($url);
}

function setDefuncion($parametros){
	$url = 'http://35.232.40.193:9002';
	$data = array(
	    'dpi' => $parametros['dpi'],
	    'fecha' => $parametros['fecha']
	);
	$jsonData = json_encode($data);
	sendPOST($url,$jsonData);
}


#################################################################
function sendGET($url){
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => $url,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	));
	$response = curl_exec($curl);
	curl_close($curl);
	echo $response;
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