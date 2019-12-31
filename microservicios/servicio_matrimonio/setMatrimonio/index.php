<?php
include('library/template.php');

$today = date("d-m-Y"); 
//Servicio de Matrimonio - setMatrimonio 

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){


		$dataIn = json_decode(file_get_contents('php://input'), true);

		if( isset($dataIn["dpihombre"]) && isset($dataIn["dpimujer"]) && isset($dataIn["fecha"])){
			
			$dpihombre =  $dataIn["dpihombre"];
			$dpimujer =  $dataIn["dpimujer"];
			$fecha =  $dataIn["fecha"];

			$sql = $pdo->prepare("SELECT id_persona FROM Persona WHERE dpi =:dpihombre");
			$sql->bindParam(':dpihombre', $dpihombre);
			$sql->execute();
		    
		    $sql2 = $pdo->prepare("SELECT id_persona FROM Persona WHERE dpi =:dpimujer");
		    $sql2->bindParam(':dpimujer', $dpimujer);
			$sql2->execute();

		    if(json_encode($sql->fetch(PDO::FETCH_ASSOC)) == "false" || json_encode($sql2->fetch(PDO::FETCH_ASSOC)) == "false"){
		    	// no existe alguna persona -> retornar error

		    	$arr = array('estado' => '500', 'mensaje' => 'Error en operacion');
		    	echo json_encode($arr);
		    	exit();

		    }else{
		    	//las dos personas existen
		    	$sql3 = $pdo->prepare("SELECT Estado_Civil FROM Persona WHERE dpi =:dpihombre");
				$sql3->bindParam(':dpihombre', $dpihombre);
				$sql3->execute();

				$result_hombre = $sql3->fetch(PDO::FETCH_ASSOC);
		        $ec_hombre = $result_hombre['Estado_Civil'];
		        //print($ec_hombre);

				$sql4 = $pdo->prepare("SELECT Estado_Civil FROM Persona WHERE dpi =:dpimujer");
				$sql4->bindParam(':dpimujer', $dpimujer);
				$sql4->execute();

				$result_mujer = $sql4->fetch(PDO::FETCH_ASSOC);
		        $ec_mujer = $result_mujer['Estado_Civil'];
		        //print($ec_mujer);

		        if($ec_hombre == "casado" || $ec_mujer == "casado"){
		        	//error -> alguno esta casado
		        	//echo "casados no se pueden casar ";

		        	$arr = array('estado' => '500', 'mensaje' => 'Error en operacion');
		    		echo json_encode($arr);
		    		exit();

		        }else{
		        	//los dos se pueden casar

					$sql->execute();
					$result_hombre = $sql->fetch(PDO::FETCH_ASSOC);
		   			$id_hombre = $result_hombre['id_persona'];
		    		//print($id_hombre);
		    
					$sql2->execute();
					$result_mujer = $sql2->fetch(PDO::FETCH_ASSOC);
		    		$id_mujer = $result_mujer['id_persona'];
		    		//print($id_mujer);

		        	$sql5 = $pdo->prepare("INSERT INTO Matrimonio(fecha_matrimonio, Estado_Matrimonio, Persona_id_Esposa, Persona_id_Esposo) VALUES('$fecha', '1', '$id_mujer', '$id_hombre')");
				    $sql5->execute();

				    // cambiar estado civil de las personas involucradas 
				    $sql6 = $pdo->prepare("UPDATE Persona SET Estado_Civil ='casado' WHERE Persona.id_persona = '$id_hombre'");
				    $sql6->execute();

				    $sql7 = $pdo->prepare("UPDATE Persona SET Estado_Civil ='casado' WHERE Persona.id_persona = '$id_mujer'");
				    $sql7->execute();

				    $arr = array('estado' => '200', 'mensaje' => 'Ok');
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
