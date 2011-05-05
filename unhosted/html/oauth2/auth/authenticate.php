<?php

require_once('../../unhosted_includes/init.php');

try {
	$userId = $_POST['user_name'];
	$sharedCompartment = $_POST['sharedCompartment'];
	$password = $_POST['pwd'];
	$scope = $_POST['scope'];

	$token = Unhosted::registerScope($userId, $password, $scope);

	if($sharedCompartment) {
		$compartment = new Unhosted_SharedCompartment($sharedCompartment, $userId, $scope);
		$compartment->register();
	}

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