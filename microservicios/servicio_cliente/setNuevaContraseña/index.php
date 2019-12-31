<?php
include('library/template.php');

//borrador de servicio de login y generacion de contraseña

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		//servicio de generacion de contraseña

		$dataIn = json_decode(file_get_contents('php://input'), true);


		//QUEDA PENDIENTE LO DE CORREO ELECTRONICO -> ENVIAR CORREO AL PARAMETRO 
		if( isset($dataIn["dpi"]) && isset($dataIn["correo"]) && isset($dataIn["tipo"])){
			//verificar que el dpi exista y no tenga contraseña

			$dpi =  $dataIn["dpi"];
			$correo = $dataIn["correo"];


			$sql = $pdo->prepare("SELECT id_persona FROM Persona WHERE DPI =:dpi");
			$sql->bindParam(':dpi', $dpi);
			$sql->execute();

			if(json_encode($sql->fetch(PDO::FETCH_ASSOC)) == "false"){
				//no existe dpi
					$arr = array('estado' => '500', 'mensaje' => 'Error en la operacion');
		    		echo json_encode($arr);	
			}else{
				//existe dpi por lo tanto verificar si su password es nula

				$sql2 = $pdo->prepare("SELECT passw FROM Persona WHERE DPI =:dpi");
				$sql2->bindParam(':dpi', $dpi);
				$sql2->execute();
				$result = $sql2->fetch(PDO::FETCH_ASSOC);
		        $passw = $result['passw'];

		        if($passw == null){
		        	// generar passw, hacer update y enviar correo

		        	$nbase_pw = rand(1111,9999);
		        	$n_pw = strval($nbase_pw);

					$sql->execute();
					$r_id = $sql->fetch(PDO::FETCH_ASSOC);
		        	$id_persona = $r_id['id_persona'];

					$sql_update_dpi = $pdo->prepare("UPDATE Persona SET passw = '$n_pw' WHERE Persona.id_persona = '$id_persona'");
				    $sql_update_dpi->execute();

				    /*
				    //enviar correo -> por defecto un correo 
						$to_email = 'luis56009@gmail.com';
						$subject = 'Testing PHP Mail';
						$message = 'This mail is sent using the PHP mail function';
						$headers = 'From: no-responda@renap.com';
						mail($to_email,$subject,$message,$headers);
					    //echo "The email message was sent.";
					*/ 

				    $arr = array('estado' => '200', 'mensaje' => $n_pw);
		    		echo json_encode($arr);	

		        }else{
		        	//ya tiene un passw -> no se le generara otro

		        	$arr = array('estado' => '500', 'mensaje' => 'Error en la operacion');
		    		echo json_encode($arr);	

		        }

			}

		}else{
				
		    	$arr = array('estado' => '404', 'mensaje' => 'Parametros incorrectos');
		    	echo json_encode($arr);
		}

	}

?>