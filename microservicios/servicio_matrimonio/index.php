<?php
include('library/template.php');

$today = date("d-m-Y"); 
//Servicio de Matrimonio - setMatrimonio 

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){

			if( !empty($_POST['dpiHombre']) && !empty($_POST['dpiMujer']) && !empty($_POST['fecha'])){
			
			//obtener id_persona de cada involucrado

			$dpi_Hombre =  $_POST['dpiHombre'];
			$dpi_Mujer = $_POST['dpiMujer'];
			$fecha = $_POST['fecha'];

			$sql = $pdo->prepare("SELECT id_persona FROM Persona WHERE dpi =:dpiHombre");
			$sql->bindParam(':dpiHombre', $_POST['dpiHombre']);
			$sql->execute();
		    
		    $sql2 = $pdo->prepare("SELECT id_persona FROM Persona WHERE dpi =:dpiMujer");
		    $sql2->bindParam(':dpiMujer', $_POST['dpiMujer']);
			$sql2->execute();

		    if(json_encode($sql->fetch(PDO::FETCH_ASSOC)) == "false" || json_encode($sql2->fetch(PDO::FETCH_ASSOC)) == "false"){
		    	// no existe alguna persona -> retornar error
		    	exit();
		    } else{
		    	//las dos personas existen
		    	$sql3 = $pdo->prepare("SELECT Estado_Civil FROM Persona WHERE dpi =:dpiHombre");
				$sql3->bindParam(':dpiHombre', $_POST['dpiHombre']);
				$sql3->execute();

				$result_hombre = $sql3->fetch(PDO::FETCH_ASSOC);
		        $ec_hombre = $result_hombre['Estado_Civil'];
		        //print($ec_hombre);

				$sql4 = $pdo->prepare("SELECT Estado_Civil FROM Persona WHERE dpi =:dpiHombre");
				$sql4->bindParam(':dpiHombre', $_POST['dpiMujer']);
				$sql4->execute();

				$result_mujer = $sql4->fetch(PDO::FETCH_ASSOC);
		        $ec_mujer = $result_mujer['Estado_Civil'];
		        //print($ec_mujer);

		        if($ec_hombre == "casado" || $ec_mujer == "casado"){
		        	//error -> alguno esta casado
		        	echo "casados no se pueden casar ";
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
				    $sql6 = $pdo->prepare("UPDATE Persona SET Estado_Civil ='casado' WHERE persona.id_persona = '$id_hombre'");
				    $sql6->execute();

				    $sql7 = $pdo->prepare("UPDATE Persona SET Estado_Civil ='casado' WHERE persona.id_persona = '$id_mujer'");
				    $sql7->execute();

		        }
		    }

		}
	} else if($_SERVER['REQUEST_METHOD'] == 'GET'){
		// servicio cliente externo -> consulta de defuncion 
			if( !empty($_GET['dpi'])){

				$dpi =  $_GET['dpi'];
				//Verificar si ya existe una defuncion con el dpi solicitado
				$sql = $pdo->prepare("SELECT  m.id_matrimonio as nomatrimonio, esposo.DPI as dpihombre, esposo.nombre as nombrehombre, esposo.apellido as apellidohombre, esposa.dpi as dpimujer, esposa.nombre as nombremujer, esposa.apellido as apellidomujer, m.fecha_matrimonio as fecha
										FROM Matrimonio as m, Persona as esposo, Persona as esposa
										WHERE (esposo.DPI = :dpi or esposa.DPI = :dpi)  
										and m.Estado_matrimonio = '1'
										and m.persona_id_esposa = esposa.id_persona
										and m.persona_id_esposo = esposo.id_persona;");
				$sql->bindParam(':dpi', $_GET['dpi']);
				$sql->execute();

				echo json_encode($sql->fetch(PDO::FETCH_ASSOC));

			}else {
				
			}
	}

?>
