<?php
include('library/template.php');

	if ($_SERVER['REQUEST_METHOD'] == 'GET'){
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
		    
		    echo json_encode( $sql->fetch(PDO::FETCH_ASSOC), JSON_NUMERIC_CHECK );
		    //echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
		    exit();

		} else {
			
				$arr = array('estado' => '404', 'mensaje' => 'Ruta no disponible');
		    	echo json_encode($arr);
		}
	}
?>