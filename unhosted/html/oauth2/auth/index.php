<?php


if(count($_POST)) {
	if(Unhosted::validUser($_POST["user_name"], $_POST["pwd"])) {
		header("Location:".$_POST["redirect_uri"]."?token=".$token);
		echo "redirecting you back to the application.\n";
	} else {
		echo "Wrong password!";
	}
} else {
?>
<?
}
?>
