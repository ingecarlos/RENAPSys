<?php
include('library/template.php');


//$today = date("d-m-Y"); 
//Servicio de Defuncion - setDefuncion 

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		// servicio cliente externo -> consulta de defuncion 
		$dataIn = json_decode(file_get_contents('php://input'), true);
		
		if( isset($dataIn["dpi"])){
			$dpi =  $dataIn["dpi"];
			//Verificar si ya existe una defuncion con el dpi solicitado
			$sql = $pdo->prepare("SELECT d.id_defuncion as nodefuncion, d.fecha as fecha, p.Nombre as nombre, p.Apellido as apellido FROM Defuncion as d, Persona as p WHERE p.DPI =:dpi and d.Persona_id_persona  = p.id_persona;");
			$sql->bindParam(':dpi',$dpi);
			$sql->execute();

			if(json_encode($sql->fetch(PDO::FETCH_ASSOC)) == "false"){
				// no hay defuncion asignado
				$arr = array('estado' => '500', 'mensaje' => 'Error en la operacion');
	    		echo json_encode($arr);

			}else{
				//datos de defuncion asignado
					$sql->execute();
					echo json_encode( $sql->fetch(PDO::FETCH_ASSOC), JSON_NUMERIC_CHECK );
			}

		}else {
			$arr = array('estado' => '404', 'mensaje' => 'Parametros incorrectos');
	    	echo json_encode($arr);
		}
	}
?>