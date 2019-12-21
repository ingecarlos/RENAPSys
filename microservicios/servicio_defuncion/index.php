<?php
include('library/template.php');

//$today = date("d-m-Y"); 
//Servicio de Defuncion - setDefuncion 

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			if( !empty($_POST['dpi']) && !empty($_POST['fecha'])){
			$dpi =  $_POST['dpi'];
			$fecha =  $_POST['fecha'];

			//Verificar si ya existe una defuncion con el dpi solicitado
			$sql = $pdo->prepare("SELECT Persona.id_persona FROM Defuncion, Persona WHERE Persona.dpi =:dpi and Persona.id_persona=Defuncion.persona_id_persona");
			$sql->bindParam(':dpi', $_POST['dpi']);
			$sql->execute();

			//el dpi solicitado no tiene defuncion asignada -> insertar defuncion codigo 200
		    if(json_encode($sql->fetch(PDO::FETCH_ASSOC)) == "false"){
		    		//echo $dpi;
		    		// obtener el id_persona de la persona
		    		$sql2 = $pdo->prepare("SELECT id_persona FROM Persona WHERE DPI='$dpi'");
				    $sql2->execute();
				    $result = $sql2->fetch(PDO::FETCH_ASSOC);
				    $id_persona = $result['id_persona'];
				    //print($id_persona);
				    // id_persona obtenido -> $id_persona
				    $sql3 = $pdo->prepare("INSERT INTO Defuncion(persona_id_persona, fecha) VALUES($id_persona, '$fecha')");
				    $sql3->execute();
				    exit();
			//el dpi solicitado si posee una defuncion asignada -> responder error codigo 500
		    }else{
		    	$sql->execute();
		    	echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
		    	echo 'existe defunsion';
		    exit();
			}
		}
	}else if($_SERVER['REQUEST_METHOD'] == 'GET'){
		// servicio cliente externo -> consulta de defuncion 
			if( !empty($_GET['dpi'])){

				$dpi =  $_GET['dpi'];
				//Verificar si ya existe una defuncion con el dpi solicitado
				$sql = $pdo->prepare("SELECT d.id_defuncion, d.fecha, p.Nombre , p.Apellido FROM Defuncion as d, Persona as p WHERE p.DPI =:dpi and d.Persona_id_persona  = p.id_persona;");
				$sql->bindParam(':dpi', $_GET['dpi']);
				$sql->execute();

				echo json_encode($sql->fetch(PDO::FETCH_ASSOC));

			}else {
				
			}
		}
?>