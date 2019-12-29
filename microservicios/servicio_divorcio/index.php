<?php
include('library/template.php');

$today = date("d-m-Y"); 
//Servicio de Matrimonio - setMatrimonio 

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){

		$dataIn = json_decode(file_get_contents('php://input'), true);
		$dpiEsposo =  $dataIn["dpiEsposo"];
		$dpiEsposa =  $dataIn["dpiEsposo"];
		$fecha =  $dataIn["fecha"];

			if( !empty($dpiEsposo) && !empty($dpiEsposa) && !empty($fecha)){
			
			//obtener id_persona de cada involucrado

			//$dpi_Hombre =  $_POST['dpiEsposo'];
			//$dpi_Mujer = $_POST['dpiEsposa'];
			//$fecha = $_POST['fecha'];

			$sql = $pdo->prepare("SELECT id_persona FROM Persona WHERE dpi =:dpiEsposo");
			$sql->bindParam(':dpiEsposo', $dpiEsposo);
			$sql->execute();
		    
		    $sql2 = $pdo->prepare("SELECT id_persona FROM Persona WHERE dpi =:dpiEsposa");
		    $sql2->bindParam(':dpiEsposa', $dpiEsposa);
			$sql2->execute();

		    if(json_encode($sql->fetch(PDO::FETCH_ASSOC)) == "false" || json_encode($sql2->fetch(PDO::FETCH_ASSOC)) == "false"){
		    	// no existe alguna persona -> retornar error
		    	//echo hola;
		    	
		    	$arr = array('estado' => '500', 'mensaje' => 'Error en la operacion');
		    	echo json_encode($arr);

		    	exit();
		    } else{
		    	//las dos personas existen
		    	$sql3 = $pdo->prepare("SELECT Estado_Civil FROM Persona WHERE dpi =:dpiEsposo");
				$sql3->bindParam(':dpiEsposo', $dpiEsposo);
				$sql3->execute();

				$result_hombre = $sql3->fetch(PDO::FETCH_ASSOC);
		        $ec_hombre = $result_hombre['Estado_Civil'];
		        //print($ec_hombre);

				$sql4 = $pdo->prepare("SELECT Estado_Civil FROM Persona WHERE dpi =:dpiEsposo");
				$sql4->bindParam(':dpiEsposo', $dpiEsposa);
				$sql4->execute();

				$result_mujer = $sql4->fetch(PDO::FETCH_ASSOC);
		        $ec_mujer = $result_mujer['Estado_Civil'];
		        //print($ec_mujer);

		        if($ec_hombre == "casado" && $ec_mujer == "casado"){
		        	//las dos personas estan casadas 

		        	$sql->execute();
					$result_hombre = $sql->fetch(PDO::FETCH_ASSOC);
		   			$id_hombre = $result_hombre['id_persona'];
		    		//print($id_hombre);
		    
					$sql2->execute();
					$result_mujer = $sql2->fetch(PDO::FETCH_ASSOC);
		    		$id_mujer = $result_mujer['id_persona'];
		    		//print($id_mujer);

		    		//cambiar el estado del matrimonio a matrimonio inactivo -> 0
		    		// cambiar el estado civil de las dos personas 

				    $sql5 = $pdo->prepare("UPDATE Matrimonio SET Estado_Matrimonio ='0' , Fecha_matrimonio='$fecha' WHERE Persona_id_Esposa = '$id_mujer' and Persona_id_Esposo = '$id_hombre'");
				    $sql5->execute();

				    // cambiar estado civil de las personas involucradas 
				    $sql6 = $pdo->prepare("UPDATE Persona SET Estado_Civil ='divorciado' WHERE Persona.id_persona = '$id_hombre'");
				    $sql6->execute();

				    $sql7 = $pdo->prepare("UPDATE Persona SET Estado_Civil ='divorciado' WHERE Persona.id_persona = '$id_mujer'");
				    $sql7->execute();

				    //retornar mensaje
				    $arr = array('estado' => '400', 'mensaje' => 'Ok');
		    		echo json_encode($arr);
				    exit();

		        }else{

		        	//echo "los que no estan casados no se pueden divorciar";
		        	//los dos se pueden casar

		        	$arr = array('estado' => '500', 'mensaje' => 'Error en la operacion');
		    		echo json_encode($arr);
		    		exit();

		        }
		    }

	} else {

				$arr = array('estado' => '404', 'mensaje' => 'Ruta no disponible');
		    	echo json_encode($arr);
			
		}
	}else if($_SERVER['REQUEST_METHOD'] == 'GET'){

		if( !empty($_GET['dpi'])){

				//$dpi =  $_GET['dpi'];
				//Verificar si ya existe un divorcio con el dpi solicitado
				$sql = $pdo->prepare("SELECT  m.id_matrimonio as nodivorcio, m.fecha_matrimonio as fecha, esposo.DPI as dpihombre, esposo.nombre as nombrehombre, esposo.apellido as apellidohombre, esposa.dpi as dpimujer, esposa.nombre as nombremujer, esposa.apellido as apellidomujer
										FROM Matrimonio as m, Persona as esposo, Persona as esposa
										WHERE (esposo.DPI = :dpi or esposa.DPI = :dpi)  
										and m.Estado_matrimonio = '0'
										and m.persona_id_esposa = esposa.id_persona
										and m.persona_id_esposo = esposo.id_persona;");
				$sql->bindParam(':dpi', $_GET['dpi']);
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
				
				$arr = array('estado' => '404', 'mensaje' => 'Ruta no disponible');
		    	echo json_encode($arr);
			}
	}

?>
