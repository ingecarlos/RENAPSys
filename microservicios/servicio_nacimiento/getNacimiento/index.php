<?php
include('library/template.php');

$today = date("d-m-Y"); 
//Servicio de Matrimonio - setMatrimonio 

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$dataIn = json_decode(file_get_contents('php://input'), true);
		
		// servicio cliente externo -> consulta de defuncion 
			if( isset($dataIn['dpipadremadre'])){
				$dpi =  $dataIn["dpipadremadre"];

				$sql = $pdo->prepare("SELECT AsigT.id_asignacion_tutor as noacta, Hijo.Apellido as apellidos, Hijo.Nombre as nombre, 
									Tutor.DPI as dpipadre, Tutor.Nombre as nombrepadre, Tutor.Apellido as apellidopadre, 
									Tutora.DPI as dpimadre, Tutora.Apellido as apellidomadre, Tutora.Nombre as nombremadre,
									Hijo.Fecha_nacimiento as fechanac, Dept.Nombre_departamento as departamento, Muni.Nombre_municipio as municipio,
									Hijo.Genero as genero
									FROM Asignacion_Tutor as AsigT, Persona as Tutor, Persona as Tutora, Persona as Hijo , Departamento as Dept , Municipio as Muni
									WHERE (Tutor.DPI =:dpiPadreMadre OR Tutora.DPI =:dpiPadreMadre)
									AND Tutor.id_persona = AsigT.Persona_id_tutor
									AND Tutora.id_persona = AsigT.Persona_id_tutora
									AND Hijo.id_persona = AsigT.Persona_id_persona
									AND Hijo.Municipio_id_municipio = Muni.id_municipio
									AND Muni.Departamento_id_departamento = Dept.id_departamento;");
				$sql->bindParam(':dpiPadreMadre',$dpi);
				$sql->execute();


				if(json_encode($sql->fetch(PDO::FETCH_ASSOC)) == "false"){
					// no hay hijos asignados

					$arr = array('estado' => '500', 'mensaje' => 'Error en la operacion');
		    		echo json_encode($arr);

				}else{
					//datos de nacimiento asignada
						//$sql->execute();
						//echo json_encode( $sql->fetch(PDO::FETCH_ASSOC), JSON_NUMERIC_CHECK );

					
						$rows = $sql->fetch(PDO::FETCH_ASSOC);
						$sql->execute();
						while( $row = $sql->fetch(PDO::FETCH_ASSOC)) {
									$json[] = $row;
						}
						
						echo json_encode( $json, JSON_NUMERIC_CHECK);


						//echo json_encode($sql->fetch(PDO::FETCH_ASSOC));	
						exit();		
				}

			}else {
				
				$arr = array('estado' => '404', 'mensaje' => 'Parametros incorrectos');
		    	echo json_encode($arr);
			}
	}

?>
