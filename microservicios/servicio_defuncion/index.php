<?php
include('library/template.php');


//$today = date("d-m-Y"); 
//Servicio de Defuncion - setDefuncion 


	if ($_SERVER['REQUEST_METHOD'] == 'POST'){

		$dataIn = json_decode(file_get_contents('php://input'), true);
		$dpi =  $dataIn["dpi"];
		$fecha =  $dataIn["fecha"];
		if( !empty($dpi) && !empty($fecha)){
			
			//Verificar si ya existe una defuncion con el dpi solicitado
			$sql = $pdo->prepare("SELECT Persona.id_persona FROM Defuncion, Persona WHERE Persona.dpi =:dpi and Persona.id_persona=Defuncion.persona_id_persona");
			$sql->bindParam(':dpi', $_POST['dpi']);
			$sql->execute();

				//el dpi solicitado no tiene defuncion asignada -> insertar defuncion codigo 200
			    if(json_encode($sql->fetch(PDO::FETCH_ASSOC)) == "false"){
			    		//echo $dpi;
			    		// obtener el id_persona de la persona
			    		$sql2 = $pdo->prepare("SELECT id_persona FROM Persona WHERE DPI='$dpi'");
					    $sql2->execute();
					    $result = $sql2->fetch(PDO::FETCH_ASSOC);
					    $id_persona = $result['id_persona'];
					    //print($id_persona);
					    // id_persona obtenido -> $id_persona
					    $sql3 = $pdo->prepare("INSERT INTO Defuncion(Persona_id_persona, fecha) VALUES($id_persona, '$fecha');");
					    $sql3->execute();

					    $arr = array('estado' => '200', 'mensaje' => 'Ok');
			    		echo json_encode($arr);

					    exit();
				//el dpi solicitado si posee una defuncion asignada -> responder error codigo 500
			    }else{
			    	//$sql->execute();
			    	//echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
			    	//echo 'existe defunsion';
			    	$arr = array('estado' => '500', 'mensaje' => 'Error en la operacion');
			    	echo json_encode($arr);

			    	exit();
				}
			}else{
				
				$arr = array('estado' => '404', 'mensaje' => 'Ruta no disponible');
		    	echo json_encode($arr);
			}

	}else if($_SERVER['REQUEST_METHOD'] == 'GET'){
		// servicio cliente externo -> consulta de defuncion 
			if( !empty($_GET['dpi'])){

				$dpi =  $_GET['dpi'];
				//Verificar si ya existe una defuncion con el dpi solicitado
				$sql = $pdo->prepare("SELECT d.id_defuncion as nodefuncion, d.fecha as fecha, p.Nombre as nombre, p.Apellido as apellido FROM Defuncion as d, Persona as p WHERE p.DPI =:dpi and d.Persona_id_persona  = p.id_persona;");
				$sql->bindParam(':dpi', $_GET['dpi']);
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
				
				$arr = array('estado' => '404', 'mensaje' => 'Ruta no disponible');
		    	echo json_encode($arr);
			}
		}
?>