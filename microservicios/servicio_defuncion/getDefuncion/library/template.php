<?php
header('Content-Type: application/json');
$success = false;
$data = array();
include('config.php');

function reponse_json($success, $data, $msgErreur=NULL) {
	$array['success'] = $success;
	$array['msg'] = $msgErreur;
	$array['result'] = $data;

	echo json_encode($data);
}

  //Asociar todos los parametros a un sql
	function bindAllValues($statement, $params)
  {
		foreach($params as $param => $value)
    {
				$statement->bindValue(':'.$param, $value);
		}
		return $statement;
   }

?>