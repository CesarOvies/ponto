<?php 

require_once('../../class/functions.php');
require_once('../../class/cxoi.class.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$user = (isset($_POST['inputUser'])) ? $_POST['inputUser'] : '';
	$pass = (isset($_POST['inputPass'])) ? $_POST['inputPass'] : '';
	if (validaUsuario($user, $pass) == true) {
		header("Location: main.php");
	} 
	else {
		expulsaVisitante();
	}
}
?>