<?php
include('library/template.php');

$today = date("d-m-Y"); 
//Servicio de Matrimonio - setMatrimonio 

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){

			if( !empty($_POST['dpiEsposo']) && !empty($_POST['dpiEsposa']) && !empty($_POST['fecha'])){
			
			//obtener id_persona de cada involucrado

			$dpi_Hombre =  $_POST['dpiEsposo'];
			$dpi_Mujer = $_POST['dpiEsposa'];
			$fecha = $_POST['fecha'];

			$sql = $pdo->prepare("SELECT id_persona FROM persona WHERE dpi =:dpiEsposo");
			$sql->bindParam(':dpiEsposo', $_POST['dpiEsposo']);
			$sql->execute();
		    
		    $sql2 = $pdo->prepare("SELECT id_persona FROM persona WHERE dpi =:dpiEsposa");
		    $sql2->bindParam(':dpiEsposa', $_POST['dpiEsposa']);
			$sql2->execute();

		    if(json_encode($sql->fetch(PDO::FETCH_ASSOC)) == "false" || json_encode($sql2->fetch(PDO::FETCH_ASSOC)) == "false"){
		    	// no existe alguna persona -> retornar error
		    	echo hola;
		    	exit();
		    } else{
		    	//las dos personas existen
		    	$sql3 = $pdo->prepare("SELECT Estado_Civil FROM persona WHERE dpi =:dpiEsposo");
				$sql3->bindParam(':dpiEsposo', $_POST['dpiEsposo']);
				$sql3->execute();

				$result_hombre = $sql3->fetch(PDO::FETCH_ASSOC);
		        $ec_hombre = $result_hombre['Estado_Civil'];
		        //print($ec_hombre);

				$sql4 = $pdo->prepare("SELECT Estado_Civil FROM persona WHERE dpi =:dpiEsposo");
				$sql4->bindParam(':dpiEsposo', $_POST['dpiEsposa']);
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

				    $sql5 = $pdo->prepare("UPDATE matrimonio SET Estado_Matrimonio ='0' , Fecha_matrimonio='$fecha' WHERE Persona_id_Esposa = $id_mujer and Persona_id_Esposo = $id_hombre");
				    $sql5->execute();

				    // cambiar estado civil de las personas involucradas 
				    $sql6 = $pdo->prepare("UPDATE persona SET Estado_Civil ='divorciado' WHERE persona.id_persona = $id_hombre");
				    $sql6->execute();

				    $sql7 = $pdo->prepare("UPDATE persona SET Estado_Civil ='divorciado' WHERE persona.id_persona = $id_mujer");
				    $sql7->execute();

		        }else{

		        	echo "los que no estan casados no se pueden divorciar";
		        	//los dos se pueden casar

		        }
		    }

	} else {
			
		}
	}else if($_SERVER['REQUEST_METHOD'] == 'GET'){

		if( !empty($_GET['dpi'])){

				$dpi =  $_GET['dpi'];
				//Verificar si ya existe un divorcio con el dpi solicitado
				$sql = $pdo->prepare("SELECT  m.id_matrimonio as nodivorcio, m.fecha_matrimonio as fecha, esposo.DPI as dpihombre, esposo.nombre as nombrehombre, esposo.apellido as apellidohombre, esposa.dpi as dpimujer, esposa.nombre as nombremujer, esposa.apellido as apellidomujer
										FROM matrimonio as m, persona as esposo, persona as esposa
										WHERE (esposo.DPI = :dpi or esposa.DPI = :dpi)  
										and m.Estado_matrimonio = '0'
										and m.persona_id_esposa = esposa.id_persona
										and m.persona_id_esposo = esposo.id_persona;");
				$sql->bindParam(':dpi', $_GET['dpi']);
				$sql->execute();

				echo json_encode($sql->fetch(PDO::FETCH_ASSOC));

			}else {
				
			}
	}

?>
