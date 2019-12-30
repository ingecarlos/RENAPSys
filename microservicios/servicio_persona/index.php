<?php
include('library/template.php');
$today = date("d-m-Y"); 

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

				//acta si existe, por lo tanto verificar si ya tiene dpi y es mayor de 18 años 

				$sql_persona = $pdo->prepare("SELECT P.DPI as dpi
									FROM Asignacion_Tutor as AsigT, Persona as P
									WHERE AsigT.id_asignacion_tutor = :numeroActa
									AND P.id_persona = AsigT.Persona_id_persona");
				$sql_persona->bindParam(':numeroActa', $numeroActa);
				$sql_persona->execute();

				$result = $sql_persona->fetch(PDO::FETCH_ASSOC);
		        $dpi_persona = $result['dpi'];
		        
		        //echo $dpi_persona;

		        $sql_persona_edad = $pdo->prepare("SELECT P.Fecha_nacimiento as Fecha_nacimiento
									FROM Asignacion_Tutor as AsigT, Persona as P
									WHERE AsigT.id_asignacion_tutor = :numeroActa
									AND P.id_persona = AsigT.Persona_id_persona");
				$sql_persona_edad->bindParam(':numeroActa', $numeroActa);
				$sql_persona_edad->execute();

				$res = $sql_persona_edad->fetch(PDO::FETCH_ASSOC);
		        $fecha_nacimiento = $res['Fecha_nacimiento'];


		        //calcular su edad
		        $fecha_nueva = new DateTime($today);
				$fecha_vieja = new DateTime($fecha_nacimiento);
				$intervalo = date_diff($fecha_vieja, $fecha_nueva);
				echo $intervalo->format('%a days');



				// si no tiene dpi y es mayor de 18 años -> generar dpi
		        if($dpi_persona == null && (int)$intervalo->format('%a')>6570){
		        	// no tiene dpi por lo tanto proseguir
		        	//echo "sin dpi";

		        	//para generar el dpi se necesita de los valores de :
		        	//codigo de departamento
		        	//codigo de municipio
		        	//id_persona

		        	$sql->execute();
		        	$result2 = $sql->fetch(PDO::FETCH_ASSOC);
		        	$id_persona = $result2['id_persona'];  // <--- id_persona

		        	$sql_muni = $pdo->prepare("SELECT M.codigo_municipio as codigomuni
												FROM Municipio as M , Persona as P
												WHERE P.Municipio_id_municipio = M.id_municipio
												AND P.id_persona = :id_persona");

					$sql_muni->bindParam(':id_persona', $id_persona);
					$sql_muni->execute();

					$result3 = $sql_muni->fetch(PDO::FETCH_ASSOC);
		        	$codigo_municipio = $result3['codigomuni']; // <- codigo de muni

		        	// una vez obtenidos estos valores se genera un numero random entre 1111 11111 y 9999 99999 adherido al codigo de muni
		        	// consultar que el dpi no existe
		        	// si existe volver a generar hasta que se cree uno inexistente

		        	$nbase_dpi = rand(100000000,999999999);
		        	$n_dpi = strval($nbase_dpi) .  strval($codigo_municipio);
		        	//echo $n_dpi;

		        	
		        	$sql_dpi_consulta = $pdo->prepare("SELECT P.id_persona as id_persona
											FROM Persona as P
											WHERE P.DPI =:nuevo_dpi");
					$sql_dpi_consulta->bindParam(':nuevo_dpi', $n_dpi);
					$sql_dpi_consulta->execute();

					if(json_encode($sql_dpi_consulta->fetch(PDO::FETCH_ASSOC)) == "false"){
						// no hay dpi existente -> dar ese dpi a la persona

						$sql_update_dpi = $pdo->prepare("UPDATE Persona SET DPI = '$n_dpi' WHERE Persona.id_persona = '$id_persona'");
				    	$sql_update_dpi->execute();

		        		$arr = array('estado' => '200', 'mensaje' => 'Ok');
		    			echo json_encode($arr);

					}else{
						//el dpi existe -> volver a generar -> consultar y condicionales
						
						$bandera = true;

						while($bandera){
							//volver a calcular
							$nbase_dpi = rand(100000000,999999999);
							$n_dpi = strval($nbase_dpi) .  strval($codigo_municipio);

							$sql_dpi_consulta->execute();
							// el dpi no existe -> insertar 
							if(json_encode($sql_dpi_consulta->fetch(PDO::FETCH_ASSOC)) == "false"){

								$bandera = false;
								$sql_update_dpi = $pdo->prepare("UPDATE Persona SET DPI = '$n_dpi' WHERE Persona.id_persona = '$id_persona'");
				    			$sql_update_dpi->execute();

				        		$arr = array('estado' => '200', 'mensaje' => 'Ok');
				    			echo json_encode($arr);

							}else{
								// el dpi existe, volver a calcular 

							}

						}

					}					

		        }else{

		        	// tiene dpi y mas de 18 , no se le puede generar nada mas 
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