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

			if( isset($dataIn["dpi"]) && isset($dataIn["tipo"]) && isset($dataIn["añosantiguedad"])){
			
				//$setLicencia = false;

				$dpi =  $dataIn["dpi"];
				$tipo =  $dataIn["tipo"];
				$añosAntiguedad = $dataIn["añosantiguedad"];

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
								$arr = array('estado' => '500', 'mensaje' => 'Error en la operacion');
		    					echo json_encode($arr);
		    					exit();
						}
					}

			}else{

				$arr = array('estado' => '404', 'mensaje' => 'Parametros incorrectos');
		    	echo json_encode($arr);
			}
		}

?>