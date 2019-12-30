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
				case '/getnacimiento':
					getNacimiento($parametros);
					break;
				case '/setnacimiento':
					setNacimiento($parametros);
					break;
				#Matrimonio
				case '/getmatrimonio':
					getMatrimonio($parametros);
					break;
				case '/setmatrimonio':
					setMatrimonio($parametros);
					break;
				#Defuncion
				case '/getdefuncion':
					getDefuncion($parametros);
					break;
				case '/setdefuncion':
					setDefuncion($parametros);
					break;
				#Divorcio
				case '/getdivorcios':
					getDivorcios($parametros);
					break;
				case '/setdivorcio':
					setDivorcio($parametros);
					break;
				#DPI
				case '/getdpi':
					getDPI($parametros);
					break;
				case '/setdpi':
					setDPI($parametros);
					break;
				#Licencia
				case '/getlicencia':
					getLicencia($parametros);
					break;
				case '/setlicencia':
					setLicencia($parametros);
					break;
				case '/setactualizar':
					setActualizar($parametros);
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
	$url = $url.'dpipadremadre='.$parametros['dpipadremadre'];
	sendGET($url);
}

function setNacimiento($parametros){
	$url = 'http://35.232.40.193:9000';
	$data = array(
	    'dpipadre' => $parametros['dpipadre'],
	    'dpimadre' => $parametros['dpimadre'],
	    'apellido' => $parametros['apellido'],
	    'nombre' => $parametros['nombre'],
	    'fechanacimiento' => $parametros['fechanacimiento'],
	    'genero' => $parametros['genero'],
	    'departamento' => $parametros['departamento'],
	    'municipio' => $parametros['municipio']
	);
	$jsonData = json_encode($data);
	sendPOST($url,$jsonData);
}

#################### MATRIMONIO ############################
function getMatrimonio($parametros){
	$url = 'http://35.232.40.193:9001/?';
	$url = $url.'dpi='.$parametros['dpi'];
	sendGET($url);
}

function setMatrimonio($parametros){
	$url = 'http://35.232.40.193:9001';
	$data = array(
	    'dpihombre' => $parametros['dpihombre'],
	    'dpimujer' => $parametros['dpimujer'],
	    'fecha' => $parametros['fecha']
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

#################### DIVORCIO ############################
function getDivorcios($parametros){
	$url = 'http://35.232.40.193:9003/?';
	$url = $url.'dpi='.$parametros['dpi'];
	sendGET($url);
}

function setDivorcio($parametros){
	$url = 'http://35.232.40.193:9003';
	$data = array(
	    'dpiesposo' => $parametros['dpiesposo'],
	    'dpiesposa' => $parametros['dpiesposa'],
	    'fecha' => $parametros['fecha']
	);
	$jsonData = json_encode($data);
	sendPOST($url,$jsonData);
}

#################### DPI ############################
function getDPI($parametros){
	$url = 'http://35.232.40.193:9004/?';
	$url = $url.'dpi='.$parametros['dpi'];
	sendGET($url);
}

function setDPI($parametros){
	$url = 'http://35.232.40.193:9004';
	$data = array(
	    'numeroacta' => $parametros['numeroActa']
	);
	$jsonData = json_encode($data);
	sendPOST($url,$jsonData);
}

#################### LICENCIA ############################
function getLicencia($parametros){
	$url = 'http://35.232.40.193:9005/?';
	$url = $url.'dpi='.$parametros['dpi'];
	sendGET($url);
}

function setLicencia($parametros){
	$url = 'http://35.232.40.193:9005';
	$data = array(
	    'dpi' => $parametros['dpi'],
	    'tipo' => $parametros['tipo'],
	    'añosantiguedad' => $parametros['añosantiguedad']
	);
	$jsonData = json_encode($data);
	sendPOST($url,$jsonData);
}

function setActualizar($parametros){
	$url = 'http://35.232.40.193:9005';
	$data = array(
	    'dpi' => $parametros['dpi'],
	    'tipo' => $parametros['tipo'],
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