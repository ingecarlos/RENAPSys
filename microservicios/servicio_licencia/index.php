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
		$dpi =  $dataIn["dpi"];
		$tipo =  $dataIn["tipo"];
		$añosAntiguedad = $dataIn["añosAntiguedad"];

		$setActualizar = true;

		//echo $añosAntiguedad;

			if( !empty($dpi) && !empty($tipo) && isset($añosAntiguedad)){
			
				$setLicencia = false;
				//$dpi =  $_POST['dpi'];
				//$tipo =  $_POST['tipo'];
				//$añosAntiguedad = $_POST['añosAntiguedad'];

				//Verificar si la persona existe - > tiene dpi o no ?

				$sql = $pdo->prepare("SELECT Persona.id_persona FROM Persona WHERE Persona.dpi =:dpi");
				$sql->bindParam(':dpi', $dpi);
				$sql->execute();


					//Si el dpi no existe -> no se le puede asignar una licencia 
				    if(json_encode($sql->fetch(PDO::FETCH_ASSOC)) == "false"){
				    	// sin dpi -> edad minima
				    	// existencia de dpi
				    }else{

				    	//la persona tiene un dpi
				    	// ¿la persona ya tiene una licencia asignada?
				    	$sql_licencia = $pdo->prepare("SELECT Al.idAsignacion_licencia FROM Persona as P , Asignacion_licencia as Al WHERE P.DPI =:dpi AND P.id_persona = Al.Persona_id_persona");
						$sql_licencia->bindParam(':dpi', $dpi);
						$sql_licencia->execute();

						//la persona no tiene una licencia asignada
						if(json_encode($sql_licencia->fetch(PDO::FETCH_ASSOC)) == "false"){
							// asignar una licencia nueva a la persona del tipo c o m 
							if($tipo=="c" || $tipo=="m"){

								//asignar licencia

								//obtener id persona

								$sql->execute();
								$id_personaJson = $sql->fetch(PDO::FETCH_ASSOC);
				        		$id_persona = $id_personaJson['id_persona'];

				        		//obtener tipo licencia

				        		$sql_tipo = $pdo->prepare("SELECT id_tipo_licencia FROM Tipo_Licencia WHERE Descripcion_Letra =:tipo");
								$sql_tipo->bindParam(':tipo', $tipo);
								$sql_tipo->execute();
								$id_tipoJson = $sql_tipo->fetch(PDO::FETCH_ASSOC);
				        		$id_tipo = $id_tipoJson['id_tipo_licencia'];

				        		//insertar registro  -> Asignacion_licencia en minuscula 
				        		$sql_nueva = $pdo->prepare("INSERT INTO Asignacion_licencia(Fecha_asignacion, Persona_id_persona, Tipo_Licencia_id_tipo_licencia) VALUES('$today', '$id_persona', '$id_tipo')");
				    			$sql_nueva->execute();

				    			$arr = array('estado' => '200', 'mensaje' => 'Ok');
		    					echo json_encode($arr);
				    			
				    			exit();

							}else{
								//no se puede asignar una primera licencia de tipo A o B 
								$arr = array('estado' => '500', 'mensaje' => 'Error en la operacion');
		    					echo json_encode($arr);
								
								exit();
							}

						}else{
							//ya posee una licencia , por lo tanto no se le puede asignar otra -> eso es actualizar 
						}
					}

			}else if(!empty($dpi) && !empty($tipo) && $setActualizar){

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
						}

					}

			}

	}else if($_SERVER['REQUEST_METHOD'] == 'GET'){
				// servicio cliente externo -> consulta de licencia
			if( !empty($_GET['dpi'])){

				$dpi =  $_GET['dpi'];
				//Verificar si existe la persona y licencia asignada
				$sql = $pdo->prepare("SELECT P.Apellido as apellidos, P.Nombre as nombre, T.Descripcion_Letra as tipo, AL.Fecha_asignacion as fechanac
										FROM Persona as P , Asignacion_licencia as AL, Tipo_Licencia as T
										WHERE P.DPI = :dpi
										AND P.id_persona = AL.Persona_id_persona
										AND AL.Tipo_Licencia_id_tipo_licencia = T.id_tipo_licencia;");
				$sql->bindParam(':dpi', $_GET['dpi']);
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

				$arr = array('estado' => '404', 'mensaje' => 'Ruta no disponible');
		    	echo json_encode($arr);
			}

	}
?>