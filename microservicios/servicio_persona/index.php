<?php
include('library/template.php');
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){

		$dataIn = json_decode(file_get_contents('php://input'), true);
		$numeroActa =  $dataIn["numeroActa"];

		if( !empty($numeroActa)){

			//Verificar si existe el acta

			$sql = $pdo->prepare("SELECT P.id_persona as id_persona
									FROM Asignacion_Tutor as AsigT, Persona as P
									WHERE AsigT.id_asignacion_tutor = :numeroActa
									AND P.id_persona = AsigT.Persona_id_persona");
			$sql->bindParam(':numeroActa', $numeroActa);
			$sql->execute();

			if(json_encode($sql->fetch(PDO::FETCH_ASSOC)) == "false"){

					// numeroActa no existe
					$arr = array('estado' => '500', 'mensaje' => 'Error en la operacion');
		    		echo json_encode($arr);
			}else{
				//acta si existe, por lo tanto verificar si ya tiene dpi 


				$sql_persona = $pdo->prepare("SELECT P.DPI as dpi
									FROM Asignacion_Tutor as AsigT, Persona as P
									WHERE AsigT.id_asignacion_tutor = :numeroActa
									AND P.id_persona = AsigT.Persona_id_persona");
				$sql_persona->bindParam(':numeroActa', $numeroActa);
				$sql_persona->execute();

				$result = $sql_persona->fetch(PDO::FETCH_ASSOC);
		        $dpi_persona = $result['dpi'];
		        
		        //echo $dpi_persona;


		        if($dpi_persona == null){
		        	// no tiene dpi por lo tanto proseguir
		        	//echo "sin dpi";

		        	

		        	$arr = array('estado' => '200', 'mensaje' => 'Ok');
		    		echo json_encode($arr);

		        }else{

		        	// tiene dpi, no se le puede generar nada mas 
					$arr = array('estado' => '500', 'mensaje' => 'Error en la operacion');
		    		echo json_encode($arr);

		        }

				//$sql->execute();
				//echo json_encode( $sql->fetch(PDO::FETCH_ASSOC), JSON_NUMERIC_CHECK );
			}



		}else{
			// no se enviaron los parametros
				$arr = array('estado' => '404', 'mensaje' => 'Ruta no disponible');
		    	echo json_encode($arr);
		}

	}else if ($_SERVER['REQUEST_METHOD'] == 'GET'){

		if( !empty($_GET['dpi']) ){

			$sql = $pdo->prepare("SELECT P.Apellido as apellidos, P.Nombre as nombre, P.Fecha_nacimiento as fechanac,
									D.Nombre_departamento as departamento, M.Nombre_municipio as municipio,
									P.Genero as genero, P.Estado_Civil as estadocivil
									FROM Persona as P , Municipio as M, Departamento as D 
									WHERE P.DPI = :dpi 
									AND P.Municipio_id_municipio = M.id_municipio
									AND M.Departamento_id_departamento = D.id_departamento;");
			$sql->bindParam(':dpi', $_GET['dpi']);
			$sql->execute();
		    
				if(json_encode($sql->fetch(PDO::FETCH_ASSOC)) == "false"){
					// no hay dpi existente

					$arr = array('estado' => '500', 'mensaje' => 'Error en la operacion');
		    		echo json_encode($arr);

				}else{
					//datos de persona por dpi
						$sql->execute();
						echo json_encode( $sql->fetch(PDO::FETCH_ASSOC), JSON_NUMERIC_CHECK );
						//echo json_encode($sql->fetch(PDO::FETCH_ASSOC));	
						exit();		
				}

		} else {
			
				$arr = array('estado' => '404', 'mensaje' => 'Ruta no disponible');
		    	echo json_encode($arr);
		}
	}
?>