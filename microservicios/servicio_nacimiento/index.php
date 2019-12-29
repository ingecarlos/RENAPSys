<?php
include('library/template.php');

$today = date("d-m-Y"); 
//Servicio de Matrimonio - setMatrimonio 


	if ($_SERVER['REQUEST_METHOD'] == 'POST'){

		$dataIn = json_decode(file_get_contents('php://input'), true);
		$dpiPadre =  $dataIn["dpiPadre"];
		$dpiMadre =  $dataIn["dpiMadre"];
		$apellido =  $dataIn["apellido"];
		$nombre =  $dataIn["nombre"];		
		$fechaNacimiento =  $dataIn["fechaNacimiento"];		
		$genero =  $dataIn["genero"];
		$departamento =  $dataIn["departamento"];
		$municipio =  $dataIn["municipio"];


		if( !empty($dpiPadre) && !empty($dpiMadre) && !empty($apellido) &&  !empty($nombre) &&  !empty($fechaNacimiento) && !empty($genero) && !empty($departamento) && !empty($municipio)){
			
			//obtener datos de parametro
			/*
			$dpiPadre =  $_POST['dpiPadre'];
			$dpiMadre = $_POST['dpiMadre'];
			$apellido = $_POST['apellido'];
			$nombre = $_POST['nombre'];
			$fechaNacimiento = $_POST['fechaNacimiento'];
			$genero = $_POST['genero'];
			$departamento = $_POST['departamento'];
			$municipio = $_POST['municipio'];
			*/
			//comprobar que existan ambos padres para insertar 

			$sql_padre = $pdo->prepare("SELECT id_persona FROM Persona WHERE dpi =:dpiPadre");
			$sql_padre->bindParam(':dpiPadre', $dpiPadre);
			$sql_padre->execute();

			$sql_madre = $pdo->prepare("SELECT id_persona FROM Persona WHERE dpi =:dpiMadre");
		    $sql_madre->bindParam(':dpiMadre', $dpiMadre);
			$sql_madre->execute();

			$sql_depto = $pdo->prepare("SELECT id_departamento FROM Departamento WHERE codigo_departamento =:departamento");
		    $sql_depto->bindParam(':departamento', $departamento);
			$sql_depto->execute();

			$sql_muni = $pdo->prepare("SELECT Municipio.id_municipio FROM Municipio, Departamento WHERE Municipio.Departamento_id_Departamento = Departamento.id_departamento and Municipio.codigo_municipio =:municipio");
		    $sql_muni->bindParam(':municipio', $municipio);
			$sql_muni->execute();

				if(json_encode($sql_padre->fetch(PDO::FETCH_ASSOC)) == "false" || json_encode($sql_madre->fetch(PDO::FETCH_ASSOC)) == "false"){

					//alguno de los padres no existe -> no insertar nacimiento
					//echo "todo mal";

					$arr = array('estado' => '500', 'mensaje' => 'Error en la operacion');
		    		echo json_encode($arr);

				}else{
					//echo "todo bien";
					
					$sql_muni->execute();

					$result_muni = $sql_muni->fetch(PDO::FETCH_ASSOC);
		        	$id_muni = $result_muni['id_municipio'];
		        	
		        	//print($nombre);
		        	//print($apellido);
		        	//print($fechaNacimiento);
		        	//print($genero);
		        	//print($id_muni);

		        	$soltero = "soltero";

					// insertar nueva persona -> se necesita -> codigo de municipio
					$sql_nueva = $pdo->prepare("INSERT INTO Persona(Nombre, Apellido, Genero, Estado_Civil, Fecha_nacimiento, Municipio_id_municipio) VALUES('$nombre', '$apellido', '$genero', '$soltero', '$fechaNacimiento', $id_muni);");
					$sql_nueva->execute();



					$sql_madre->execute();
					$result_madre = $sql_madre->fetch(PDO::FETCH_ASSOC);
		        	$id_tutora = $result_madre['id_persona'];
					
					$sql_padre->execute();
					$result_padre = $sql_padre->fetch(PDO::FETCH_ASSOC);
		        	$id_tutor = $result_padre['id_persona'];


		        	$sql_hijo = $pdo->prepare("SELECT id_persona FROM Persona WHERE Nombre = '$nombre' and Apellido= '$apellido' and Fecha_nacimiento = '$fechaNacimiento'");
					//$sql_hijo->bindParam(':dpiPadre', $_POST['dpiPadre']);
					$sql_hijo->execute();
					$result_hijo = $sql_hijo->fetch(PDO::FETCH_ASSOC);
		        	$id_hijo = $result_hijo['id_persona'];


					$sql_nueva = $pdo->prepare("INSERT INTO Asignacion_Tutor(Persona_id_persona, Persona_id_tutora, Persona_id_tutor) VALUES('$id_hijo', '$id_tutora', '$id_tutor')");
					$sql_nueva->execute();

					$arr = array('estado' => '200', 'mensaje' => 'Ok');
		    		echo json_encode($arr);
					//echo "insercion";
				}
		    }else{

		    	$arr = array('estado' => '404', 'mensaje' => 'Ruta no disponible');
		    	echo json_encode($arr);
		    }
	}else if($_SERVER['REQUEST_METHOD'] == 'GET'){
		// servicio cliente externo -> consulta de defuncion 
			if( !empty($_GET['dpiPadreMadre'])){

				$dpi =  $_GET['dpiPadreMadre'];
				//Verificar los hijos que tiene la persona

				$sql = $pdo->prepare("SELECT AsigT.id_asignacion_tutor as noacta, Hijo.Apellido as apellidos, Hijo.Nombre as nombre, 
									Tutor.DPI as dpipadre, Tutor.Nombre as nombrepadre, Tutor.Apellido as apellidopadre, 
									Tutora.Nombre as dpimadre, Tutora.Apellido as apellidomadre, Tutora.Nombre as nombremadre,
									Hijo.Fecha_nacimiento as fechanac, Dept.Nombre_departamento as departamento, Muni.Nombre_municipio as municipio,
									Hijo.Genero as genero
									FROM Asignacion_Tutor as AsigT, Persona as Tutor, Persona as Tutora, Persona as Hijo , Departamento as Dept , Municipio as Muni
									WHERE (Tutor.DPI =:dpiPadreMadre OR Tutora.DPI =:dpiPadreMadre)
									AND Tutor.id_persona = AsigT.Persona_id_tutor
									AND Tutora.id_persona = AsigT.Persona_id_tutora
									AND Hijo.id_persona = AsigT.Persona_id_persona
									AND Hijo.Municipio_id_municipio = Muni.id_municipio
									AND Muni.Departamento_id_departamento = Dept.id_departamento;");
				$sql->bindParam(':dpiPadreMadre', $_GET['dpiPadreMadre']);
				$sql->execute();


				if(json_encode($sql->fetch(PDO::FETCH_ASSOC)) == "false"){
					// no hay hijos asignados

					$arr = array('estado' => '500', 'mensaje' => 'Error en la operacion');
		    		echo json_encode($arr);

				}else{
					//datos de nacimiento asignada
						//$sql->execute();
						//echo json_encode( $sql->fetch(PDO::FETCH_ASSOC), JSON_NUMERIC_CHECK );

					
						$rows = $sql->fetch(PDO::FETCH_ASSOC);
						$sql->execute();
						while( $row = $sql->fetch(PDO::FETCH_ASSOC)) {
									$json[] = $row;
						}
						
						echo json_encode( $json, JSON_NUMERIC_CHECK);


						//echo json_encode($sql->fetch(PDO::FETCH_ASSOC));	
						exit();		
				}

			}else {
				
				$arr = array('estado' => '404', 'mensaje' => 'Ruta no disponible');
		    	echo json_encode($arr);
			}
	}



?>
