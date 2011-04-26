<?php

require_once('unhosted_includes/init.php');

try {
	$result = array();

	$userName = $_POST['user_name'];
	$password = $_POST['pwd'];
	$scope = $_POST['scope'];

	Unhosted::registerUser($userName, $password);
	$result['userCreated'] = true;

	if($scope) {
		$token = Unhosted::registerScope($userName, $password, $scope);
		$result['token'] = $token;
	}

	echo json_encode($result);

} catch(Exception $exception) {
	die(json_encode(array(
		'error' => true,
		'errorNum' => $exception->getCode(),
		'errorMessage' => $exception->getMessage()
	)));
}

?>