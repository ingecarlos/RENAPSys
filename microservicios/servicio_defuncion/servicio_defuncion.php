<?php
include('library/template.php');

$today = date("d-m-Y"); 
//Servicio de Defuncion - setDefuncion 

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			if( !empty($_POST['dpi']) ){
			$dpi =  $_POST['dpi'];
			//Verificar si ya existe una defuncion con el dpi solicitado
			$sql = $pdo->prepare("SELECT persona.id_persona FROM defuncion, persona WHERE persona.dpi =:dpi and persona.id_persona=defuncion.persona_id_persona");
			$sql->bindParam(':dpi', $_POST['dpi']);
			$sql->execute();

			//el dpi solicitado no tiene defuncion asignada -> insertar defuncion codigo 200
		    if(json_encode($sql->fetch(PDO::FETCH_ASSOC)) == "false"){
		    		//echo $dpi;
		    		// obtener el id_persona de la persona
		    		$sql2 = $pdo->prepare("SELECT id_persona FROM persona WHERE DPI='$dpi'");
				    $sql2->execute();
				    $result = $sql2->fetch(PDO::FETCH_ASSOC);
				    $id_persona = $result['id_persona'];
				    //print($id_persona);
				    // id_persona obtenido -> $id_persona
				    $sql3 = $pdo->prepare("INSERT INTO defuncion(persona_id_persona, fecha) VALUES($id_persona, '$today')");
				    $sql3->execute();
				    exit();
			//el dpi solicitado si posee una defuncion asignada -> responder error codigo 500
		    }else{
		    	$sql->execute();
		    	echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
		    	echo 'existe defunsion';
		    exit();
			}
	} else {
			
		}
	}

?>
