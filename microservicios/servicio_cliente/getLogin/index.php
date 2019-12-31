<?php
include('library/template.php');

//borrador de servicio de login y generacion de contraseña

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		// servicio cliente -> getLogin

			$dataIn = json_decode(file_get_contents('php://input'), true);
			

			//QUEDA PENDIENTE EL PARAMETRO TIPO STRING VER DOCU 
			
			if( isset($dataIn["dpi"]) && isset($dataIn["clave"]) && isset($dataIn["tipo"]) ){

				$dpi =  $dataIn["dpi"];
				$clave = $dataIn["clave"];

				//verificar que exista la persona y que contenga dpi 
				$sql = $pdo->prepare("SELECT id_persona
										FROM Persona
										WHERE DPI = '$dpi'
										AND passw = :clave ;");
				$sql->bindParam(':clave', $clave);
				$sql->execute();

				if(json_encode($sql->fetch(PDO::FETCH_ASSOC)) == "false"){
					// no hay persona con ese dpi

					$arr = array('estado' => '500', 'mensaje' => 'Error en la operacion');
		    		echo json_encode($arr);

				}else{
					//login correcto
						$sql->execute();
						//echo json_encode( $sql->fetch(PDO::FETCH_ASSOC), JSON_NUMERIC_CHECK );
						$arr = array('estado' => '200', 'mensaje' => 'Ok');
		    			echo json_encode($arr);
				}

			}else {
				
		    	$arr = array('estado' => '404', 'mensaje' => 'Parametros incorrectos');
		    	echo json_encode($arr);
			}
		}

?>