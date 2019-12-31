<?php
include('library/template.php');
$today = date("d-m-Y"); 

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){

		$dataIn = json_decode(file_get_contents('php://input'), true);
		
		if( isset($dataIn["dpi"])){

			$dpi =  $dataIn["dpi"];

			$sql = $pdo->prepare("SELECT P.Apellido as apellidos, P.Nombre as nombre, P.Fecha_nacimiento as fechanac,
									D.Nombre_departamento as departamento, M.Nombre_municipio as municipio,
									P.Genero as genero, P.Estado_Civil as estadocivil
									FROM Persona as P , Municipio as M, Departamento as D 
									WHERE P.DPI = :dpi 
									AND P.Municipio_id_municipio = M.id_municipio
									AND M.Departamento_id_departamento = D.id_departamento;");
			$sql->bindParam(':dpi', $dpi);
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
			
				$arr = array('estado' => '404', 'mensaje' => 'Parametros incorrectos');
		    	echo json_encode($arr);
		}
	}
?>