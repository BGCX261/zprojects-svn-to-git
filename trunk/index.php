<?php

include('app/core/init.php');
$users = new Users();

if (!empty($_COOKIE['id']) && empty($_SESSION['id'])) { // Si le membre n'est pas connecté mais l'a déjà été et a coché l'option "Se souvenir de moi"
    //A sécuriser
    $_SESSION['id'] = $_COOKIE['id']; // On le connecte
}

if (!empty($_SESSION['id'])) { // Si le membre est connecté;
	$users->refresh_date_connect($_SESSION['id']); // On rafraichit sa dernière connexion
}

//Si un module est spécifié, on regarde s'il existe
if(isset($_GET['module']) && !empty($_GET['module'])) {

	$module = dirname(__FILE__) . '/' . Core::CONTROLLERS_DIR  . $_GET['module'].'.php';

	//Si le module existe, alors on appelle son controlleur
	if(is_file($module)) {
		include $module;
	} else {
		//Sinon, on affiche la page d'erreur
            echo 'error';
		$core -> error404();
	}
} else {
	//On affiche la page d'accueil
	include Core::CONTROLLERS_DIR . 'default.php';
}