<?php
include('library/template.php');

$today = date("d-m-Y"); 
//Servicio de Matrimonio - setMatrimonio 


	if ($_SERVER['REQUEST_METHOD'] == 'POST'){

			if( !empty($_POST['dpiHombre']) && !empty($_POST['dpiMujer']) && !empty($_POST['apellido']) &&  !empty($_POST['nombre']) &&  !empty($_POST['fechaNacimiento']) &&  !empty($_POST['genero']) &&  !empty($_POST['departamento']) &&  !empty($_POST['municipio'])){
			
			//obtener datos de parametro

			$dpiHombre =  $_POST['dpiHombre'];
			$dpiMujer = $_POST['dpiMujer'];
			$apellido = $_POST['apellido'];
			$nombre = $_POST['nombre'];
			$fechaNacimiento = $_POST['fechaNacimiento'];
			$genero = $_POST['genero'];
			$departamento = $_POST['departamento'];
			$municipio = $_POST['municipio'];

			//comprobar que existan ambos padres para insertar 

			$sql_padre = $pdo->prepare("SELECT id_persona FROM Persona WHERE dpi =:dpiHombre");
			$sql_padre->bindParam(':dpiHombre', $_POST['dpiHombre']);
			$sql_padre->execute();

			$sql_madre = $pdo->prepare("SELECT id_persona FROM Persona WHERE dpi =:dpiMujer");
		    $sql_madre->bindParam(':dpiMujer', $_POST['dpiMujer']);
			$sql_madre->execute();

			$sql_depto = $pdo->prepare("SELECT id_departamento FROM Departamento WHERE Nombre_departamento =:departamento");
		    $sql_depto->bindParam(':departamento', $_POST['departamento']);
			$sql_depto->execute();

			$sql_muni = $pdo->prepare("SELECT Municipio.id_municipio FROM Municipio, Departamento WHERE Municipio.Departamento_id_Departamento = Departamento.id_departamento and Municipio.Nombre_municipio =:municipio");
		    $sql_muni->bindParam(':municipio', $_POST['municipio']);
			$sql_muni->execute();

				if(json_encode($sql_padre->fetch(PDO::FETCH_ASSOC)) == "false" || json_encode($sql_madre->fetch(PDO::FETCH_ASSOC)) == "false"){

					//alguno de los padres no existe -> no insertar nacimiento
					//echo "todo mal";
				}else{
					//echo "todo bien";
					
					$sql_muni->execute();

					$result_muni = $sql_muni->fetch(PDO::FETCH_ASSOC);
		        	$id_muni = $result_muni['id_municipio'];
		        	
		        	print($nombre);
		        	print($apellido);
		        	print($fechaNacimiento);
		        	print($genero);
		        	print($id_muni);

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
					//$sql_hijo->bindParam(':dpiHombre', $_POST['dpiHombre']);
					$sql_hijo->execute();
					$result_hijo = $sql_hijo->fetch(PDO::FETCH_ASSOC);
		        	$id_hijo = $result_hijo['id_persona'];


					$sql_nueva = $pdo->prepare("INSERT INTO Asignacion_Tutor(Persona_id_persona, Persona_id_tutora, Persona_id_tutor) VALUES('$id_hijo', '$id_tutora', '$id_tutor')");
					$sql_nueva->execute();

					//echo "insercion";
				}

		    }

		} 

?>
