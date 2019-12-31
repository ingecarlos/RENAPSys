<?php

include('library/template.php');

$today = date("d-m-Y"); 
//Servicio Licencia - setLicencia
//Parametros dpi:numero; tipo: String "c/m"; añosAntiguedad: numero 

/*
	1. Validacion de DPI -> validacion de 18 años
	2. Validacion de existencia de licencia
	3. Se le asigna una licencia con el tipo

*/

//Servicio Licencia - setActualizar
//Parametros dpi:numero; tipo:String "c/b/a/m"

//Servicio Licencia - getLicencia
//Parametros dpi:numero -> Respuesta apellido, nombre, tipo, fechanac

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
				// servicio cliente externo -> consulta de licencia
		$dataIn = json_decode(file_get_contents('php://input'), true);


			if( isset($dataIn["dpi"])){

				$dpi =  $dataIn["dpi"];

				//Verificar si existe la persona y licencia asignada
				$sql = $pdo->prepare("SELECT P.Apellido as apellidos, P.Nombre as nombre, T.Descripcion_Letra as tipo, AL.Fecha_asignacion as fechanac
										FROM Persona as P , Asignacion_licencia as AL, Tipo_Licencia as T
										WHERE P.DPI = :dpi
										AND P.id_persona = AL.Persona_id_persona
										AND AL.Tipo_Licencia_id_tipo_licencia = T.id_tipo_licencia;");
				$sql->bindParam(':dpi', $dpi);
				$sql->execute();

				if(json_encode($sql->fetch(PDO::FETCH_ASSOC)) == "false"){
					// no hay licencia asignada

					$arr = array('estado' => '500', 'mensaje' => 'Error en la operacion');
		    		echo json_encode($arr);

				}else{
					//datos de licencia asignada
						$sql->execute();
						echo json_encode( $sql->fetch(PDO::FETCH_ASSOC), JSON_NUMERIC_CHECK );
						//echo json_encode($sql->fetch(PDO::FETCH_ASSOC));			
				}
			}else{

				$arr = array('estado' => '404', 'mensaje' => 'Parametros incorrectos');
		    	echo json_encode($arr);
			}
		}
?>