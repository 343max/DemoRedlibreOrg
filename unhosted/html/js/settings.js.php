<?php

require_once('../unhosted_includes/init.php');

echo 'unhostedSettings = ' . json_encode(array(
	'domain' => UnhostedSettings::domain
)) . ';';

?>