<?php
include('library/template.php');

$today = date("d-m-Y"); 
//Servicio de Matrimonio - setMatrimonio 
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		$dataIn = json_decode(file_get_contents('php://input'), true);
		
		if( isset($dataIn['dpi']) ){
				$dpi =  $dataIn['dpi'];
				//$dpi =  $_GET['dpi'];
				//Verificar si ya existe un divorcio con el dpi solicitado
				$sql = $pdo->prepare("SELECT  m.id_matrimonio as nodivorcio, m.fecha_matrimonio as fecha, esposo.DPI as dpihombre, esposo.nombre as nombrehombre, esposo.apellido as apellidohombre, esposa.dpi as dpimujer, esposa.nombre as nombremujer, esposa.apellido as apellidomujer
										FROM Matrimonio as m, Persona as esposo, Persona as esposa
										WHERE (esposo.DPI = :dpi or esposa.DPI = :dpi)  
										and m.Estado_matrimonio = '0'
										and m.persona_id_esposa = esposa.id_persona
										and m.persona_id_esposo = esposo.id_persona;");
				$sql->bindParam(':dpi', $dpi);
				$sql->execute();

				if(json_encode($sql->fetch(PDO::FETCH_ASSOC)) == "false"){
					// no hay divorcio asignado

					$arr = array('estado' => '500', 'mensaje' => 'Error en la operacion');
		    		echo json_encode($arr);

				}else{
					//datos de divorcio asignado
						//$sql->execute();
						//echo json_encode( $sql->fetch(PDO::FETCH_ASSOC), JSON_NUMERIC_CHECK );	

						$rows = $sql->fetch(PDO::FETCH_ASSOC);
						$sql->execute();
						while( $row = $sql->fetch(PDO::FETCH_ASSOC)) {
									$json[] = $row;
						}
						
						echo json_encode( $json, JSON_NUMERIC_CHECK);	
				}

			}else {
				
				$arr = array('estado' => '404', 'mensaje' => 'Parametros incorrectos');
		    	echo json_encode($arr);
			}
	}


	
?>
