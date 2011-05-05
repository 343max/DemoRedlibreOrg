<?php

require_once('../unhosted_includes/init.php');

try {
	$userId = $_POST['user_name'];
	$sharedCompartment = $_POST['sharedCompartment'];

	$sharedCompartment = new Unhosted_SharedCompartment($sharedCompartment, $userId);

	$sharedCompartment->readInfo();

	$result = $sharedCompartment->getInfo();
	$result['exists'] = $sharedCompartment->getExists();

	echo json_encode($result);

} catch(Exception $exception) {
	die(json_encode(array(
		'error' => true,
		'errorNum' => $exception->getCode(),
		'errorMessage' => $exception->getMessage()
	)));
}
