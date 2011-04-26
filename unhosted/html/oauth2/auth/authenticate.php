<?php

require_once('../../unhosted_includes/init.php');

try {

	$token = Unhosted::registerScope($_POST['user_name'], $_POST['pwd'], $_POST['scope']);

	echo json_encode(array(
		'token' => $token	
	));

} catch(Exception $exception) {
	die(json_encode(array(
		'error' => true,
		'errorNum' => $exception->getCode(),
		'errorMessage' => $exception->getMessage()
	)));
}

?>