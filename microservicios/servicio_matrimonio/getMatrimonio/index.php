<?php
include('library/template.php');

$today = date("d-m-Y"); 
//Servicio de Matrimonio - getMatrimonio 

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		// 

		$dataIn = json_decode(file_get_contents('php://input'), true);

			if( isset($dataIn["dpi"])){

				$dpi =  $dataIn["dpi"];

				//Verificar si ya existe un matrimonio con el dpi solicitado
				$sql = $pdo->prepare("SELECT  m.id_matrimonio as nomatrimonio, esposo.DPI as dpihombre, esposo.nombre as nombrehombre, esposo.apellido as apellidohombre, esposa.dpi as dpimujer, esposa.nombre as nombremujer, esposa.apellido as apellidomujer, m.fecha_matrimonio as fecha
										FROM Matrimonio as m, Persona as esposo, Persona as esposa
										WHERE (esposo.DPI = :dpi or esposa.DPI = :dpi)  
										and m.Estado_matrimonio = '1'
										and m.persona_id_esposa = esposa.id_persona
										and m.persona_id_esposo = esposo.id_persona;");
				$sql->bindParam(':dpi', $dpi);
				$sql->execute();


				if(json_encode($sql->fetch(PDO::FETCH_ASSOC)) == "false"){
					// no hay matrimonio asignado

					$arr = array('estado' => '500', 'mensaje' => 'Error en la operacion');
		    		echo json_encode($arr);

				}else{
					//datos de matrimonio
						$sql->execute();
						echo json_encode( $sql->fetch(PDO::FETCH_ASSOC), JSON_NUMERIC_CHECK );
						//echo json_encode($sql->fetch(PDO::FETCH_ASSOC));			
				}
				
			}else {
				
				$arr = array('estado' => '404', 'mensaje' => 'Parametros incorrectos');
		    	echo json_encode($arr);
			}
	}

?>
