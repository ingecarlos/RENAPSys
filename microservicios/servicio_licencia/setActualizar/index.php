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


	if ($_SERVER['REQUEST_METHOD'] == 'POST'){


		$dataIn = json_decode(file_get_contents('php://input'), true);


		//$setActualizar = true;

		//echo $añosAntiguedad;

		if(isset($dataIn["dpi"]) && isset($dataIn["tipo"])){

			$dpi =  $dataIn["dpi"];
			$tipo =  $dataIn["tipo"];

				//Actualizar licencia
				//Actualizar licencia de "m" a "c" y "c" a "m" -> sin problemas

				//Actualizar a licencia de "c" a "b" -> necesita 2 años en "c"

				//Actualizar a licencia de "b" a "a" -> necesita 3 años en "b"

				//$dpi =  $_POST['dpi'];
				//$tipo =  $_POST['tipo'];

				$sql2 = $pdo->prepare("SELECT Persona.id_persona FROM Persona WHERE Persona.dpi =:dpi");
				$sql2->bindParam(':dpi', $dpi);
				$sql2->execute();


					//Si el dpi no existe -> no se le puede actualizar una licencia 
				    if(json_encode($sql2->fetch(PDO::FETCH_ASSOC)) == "false"){
				    	// sin dpi -> edad minima

				    	$arr = array('estado' => '500', 'mensaje' => 'Error en la operacion');
		    			echo json_encode($arr);

				    }else{

				    	//la persona tiene un dpi
				    	// ¿la persona ya tiene una licencia asignada?
				    	$sql_licencia2 = $pdo->prepare("SELECT Al.idAsignacion_licencia, Al.Fecha_asignacion , T.Descripcion_Letra FROM Persona as P , Asignacion_licencia as Al, Tipo_Licencia as T WHERE P.DPI =:dpi AND T.id_tipo_licencia = Al.Tipo_Licencia_id_tipo_licencia AND P.id_persona = Al.Persona_id_persona");
						$sql_licencia2->bindParam(':dpi', $dpi);
						$sql_licencia2->execute();

						if(json_encode($sql_licencia2->fetch(PDO::FETCH_ASSOC)) == "false"){
							// no tiene una licencia que actualizar
							//echo "no hay licencia";
							$arr = array('estado' => '500', 'mensaje' => 'Error en la operacion');
		    				echo json_encode($arr);

						}else{

							$sql_licencia2->execute();
							$id_tipoJson2 = $sql_licencia2->fetch(PDO::FETCH_ASSOC);
							$id_asignacion_licencia = $id_tipoJson2['idAsignacion_licencia'];
					        $id_tipo_letra = $id_tipoJson2['Descripcion_Letra']; // tipo de licencia actual
					        $fecha_asig = $id_tipoJson2['Fecha_asignacion']; // fecha de cuando se asigno su anterior licencia

					        //echo $id_tipo_letra;
					        //echo $today;
					        //echo $fecha_asig;

					        //verificar tiempos 
					        $fecha_nueva = new DateTime($today);
					        $fecha_vieja = new DateTime($fecha_asig);
					        $intervalo = date_diff($fecha_vieja, $fecha_nueva);
					        //echo $intervalo->format('%a days');

					        //verificar la escalada
					        if((int)$intervalo->format('%a')>730 && ($id_tipo_letra == "C" || $id_tipo_letra == "c") && ($tipo =="b" || $tipo =="B")){
					        	//echo "ya pasaron los dos años de c a b";

					        	// update de tipo de licencia y update de fecha de asignacion

					        	//traer id de nuevo tipo de licencia

								$sql_tipo_nuevo = $pdo->prepare("SELECT id_tipo_licencia FROM Tipo_Licencia WHERE Descripcion_Letra = 'B'");
								$sql_tipo_nuevo->bindParam(':dpi', $dpi);
								$sql_tipo_nuevo->execute();
								$id_tipoJsonNuevo = $sql_tipo_nuevo->fetch(PDO::FETCH_ASSOC);
					        	$id_tipo_Nuevo = $id_tipoJsonNuevo['id_tipo_licencia'];
					        	//echo $id_tipo_Nuevo;

					        	//update de fecha y tipo de licencia sobre persona

					        	$sql_update = $pdo->prepare("UPDATE Asignacion_licencia SET Fecha_asignacion ='$today' , Tipo_Licencia_id_tipo_licencia ='$id_tipo_Nuevo'  WHERE idAsignacion_licencia = '$id_asignacion_licencia'");
				    			$sql_update->execute();

								$arr = array('estado' => '200', 'mensaje' => 'Ok');
						    	echo json_encode($arr);
						    	exit();

					        }else if((int)$intervalo->format('%a')> 1095 && ($id_tipo_letra == "b" || $id_tipo_letra == "B") && ($tipo =="a" || $tipo =="A")) {
					        	//echo "ya pasaron los tres años de b a a";

					        	$sql_tipo_nuevo = $pdo->prepare("SELECT id_tipo_licencia FROM Tipo_Licencia WHERE Descripcion_Letra = 'A'");
								$sql_tipo_nuevo->bindParam(':dpi', $dpi);
								$sql_tipo_nuevo->execute();
								$id_tipoJsonNuevo = $sql_tipo_nuevo->fetch(PDO::FETCH_ASSOC);
					        	$id_tipo_Nuevo = $id_tipoJsonNuevo['id_tipo_licencia'];

					        	//update de fecha y tipo de licencia sobre persona


					        	$sql_update = $pdo->prepare("UPDATE Asignacion_licencia SET Fecha_asignacion ='$today' , Tipo_Licencia_id_tipo_licencia ='$id_tipo_Nuevo'  WHERE idAsignacion_licencia = '$id_asignacion_licencia'");
				    			$sql_update->execute();

				    			$arr = array('estado' => '200', 'mensaje' => 'Ok');
		    					echo json_encode($arr);
		    					exit();

					        }else if(($id_tipo_letra == "m" || $id_tipo_letra == "M") && ($tipo == "c" || $id_tipo_letra == "C")){
					        	//echo "se puede cambiar de licencia de moto a vehiculo m a c ";

					        	$sql_tipo_nuevo = $pdo->prepare("SELECT id_tipo_licencia FROM Tipo_Licencia WHERE Descripcion_Letra = 'C'");
								$sql_tipo_nuevo->bindParam(':dpi', $dpi);
								$sql_tipo_nuevo->execute();
								$id_tipoJsonNuevo = $sql_tipo_nuevo->fetch(PDO::FETCH_ASSOC);
					        	$id_tipo_Nuevo = $id_tipoJsonNuevo['id_tipo_licencia'];

					        	//update de fecha y tipo de licencia sobre persona

					        	$sql_update = $pdo->prepare("UPDATE Asignacion_licencia SET Fecha_asignacion ='$today' , Tipo_Licencia_id_tipo_licencia ='$id_tipo_Nuevo'  WHERE idAsignacion_licencia = '$id_asignacion_licencia'");
				    			$sql_update->execute();

				    			$arr = array('estado' => '200', 'mensaje' => 'Ok');
		    					echo json_encode($arr);
		    					exit();


					        }else if(($id_tipo_letra == "c" || $id_tipo_letra == "C") && ($tipo == "m" || $id_tipo_letra == "M")){
					        	//echo "se puede cambiar de licencia de vehiculo a motocicleta c a m ";

					        	$sql_tipo_nuevo = $pdo->prepare("SELECT id_tipo_licencia FROM Tipo_Licencia WHERE Descripcion_Letra = 'M'");
								$sql_tipo_nuevo->bindParam(':dpi', $dpi);
								$sql_tipo_nuevo->execute();
								$id_tipoJsonNuevo = $sql_tipo_nuevo->fetch(PDO::FETCH_ASSOC);
					        	$id_tipo_Nuevo = $id_tipoJsonNuevo['id_tipo_licencia'];

					        	//update de fecha y tipo de licencia sobre persona

					        	$sql_update = $pdo->prepare("UPDATE Asignacion_licencia SET Fecha_asignacion ='$today' , Tipo_Licencia_id_tipo_licencia ='$id_tipo_Nuevo'  WHERE idAsignacion_licencia = '$id_asignacion_licencia'");
				    			$sql_update->execute();


				    			$arr = array('estado' => '200', 'mensaje' => 'Ok');
		    					echo json_encode($arr);
		    					exit();


					        }else{
					        	//todos los demas son error
					        	
					        	//echo "error de requisitos";

					        	$arr = array('estado' => '500', 'mensaje' => 'Error en la operacion');
		    					echo json_encode($arr);
		    					exit();
					        }
							//echo "hola actualizar";
						}//fin else == false

					}//fin else == false

		}else{

				$arr = array('estado' => '404', 'mensaje' => 'Parametros incorrectos');
		    	echo json_encode($arr);
		}
	}
?>