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

			$sql_muni = $pdo->prepare("SELECT municipio.id_municipio FROM Municipio, Departamento WHERE municipio.Departamento_id_Departamento = departamento.id_departamento and municipio.Nombre_municipio =:municipio");
		    $sql_muni->bindParam(':municipio', $_POST['municipio']);
			$sql_muni->execute();

				if(json_encode($sql_padre->fetch(PDO::FETCH_ASSOC)) == "false" || json_encode($sql_madre->fetch(PDO::FETCH_ASSOC)) == "false"){

					//alguno de los padres no existe -> no insertar nacimiento
					echo "todo mal";
				}else{
					echo "todo bien";
					//

					// insertar nueva persona -> se necesita -> codigo de municipio
					//$sql_nueva = $pdo->prepare("INSERT INTO persona(DPI, passw, Nombre, Apellido, Genero, Estado_Civil, Fecha_nacimiento, Municipio_id_municipio) VALUES(0, '1234', $nombre, $apellido,$genero, 'soltero', '$fechaNacimiento', $id_municipio)");
					//$sql_nueva->execute();

				}

		    }

		} 

?>
