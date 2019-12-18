<?php
include('library/template.php');

	if ($_SERVER['REQUEST_METHOD'] == 'GET'){
		if( !empty($_GET['Nombre']) ){

			$sql = $pdo->prepare("SELECT * FROM persona WHERE `Nombre` =:nom");
			$sql->bindParam(':nom', $_GET['Nombre']);
			$sql->execute();
		    header("HTTP/1.1 200 OK");
		    echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
		    exit();

		} else {
			
		}
	}
?>