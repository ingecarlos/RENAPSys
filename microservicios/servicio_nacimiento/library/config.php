<?php
$hote = '35.202.248.44';
$port = "3306";
$nom_bdd = 'RENAPDB';
$utilisateur = 'root';
$mot_de_passe ='123';

try {
	//On test la connexion à la base de donnée
    $pdo = new PDO('mysql:host='.$hote.':'.$port.';dbname='.$nom_bdd, $utilisateur, $mot_de_passe);
    echo 'conexión lograda';

} catch(Exception $e) {
	//Si la connexion n'est pas établie, on stop le chargement de la page.
	reponse_json($success, $data, 'Echec de la connexion à la base de données');
    exit();

}