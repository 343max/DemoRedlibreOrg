<?php

class Unhosted {

	public static function normalizeUsername($userName) {
		$userName = strtolower($userName);

		if($userName == '') throw new Exception('no username given', 5);

		return $userName;
	}

	public static function normalizeScopeName($scope) {
		return preg_replace("/[^a-z0-9\\._-]/", '', $scope);
	}


	public static function registerUser($userName, $password) {
		if(!ctype_alnum($userName)) {
			throw new Exception("please use only alphanumeric characters in your username", 1);
		} else {
			$userDir = self::getUserDavPath($userName . '@' . UnhostedSettings::domain);
			if(is_dir($userDir)) {
				throw new Exception("This username is allready take. Please choose a different one.", 2);
			} else {//create the user
				mkdir($userDir);
				file_put_contents($userDir."/.htpasswd", sha1($password));
			}
		}
	}

	public static function validUser($userId, $password) {
		$pwdFile =  self::getUserDavPath($userId) . ".htpasswd";
		return (file_exists($pwdFile) && sha1($password) == file_get_contents($pwdFile));
	}

	public static function getUserDavPath($userId) {
		list($userName, $userDomain) = explode("@", $userId);
		$userName = self::normalizeUsername($userName);
		return UnhostedSettings::davDir . "$userDomain/$userName/";
	}

	public static function getScopeDavPath($userId, $scope) {
		$normalizedScope = self::normalizeScopeName($scope);
		if($normalizedScope == '') throw new Exception('No scope given', 4);
		return self::getUserDavPath($userId) . $normalizedScope . '/';
	}
	
	public static function registerScope($userId, $password, $scope) {

		if(!self::validUser($userId, $password)) {
			throw new Exception("The password is wrong or this user does not exists.", 3);
		}

		$token = base64_encode(mt_rand());
		$scopeDir = self::getScopeDavPath($userId, $scope);

		if(!is_dir($scopeDir)) {
			mkdir($scopeDir);
		}

		$passwdFilePath = $scopeDir . '.htpasswd';

		$htaccessContent = '<LimitExcept OPTIONS HEAD GET>
  AuthType Basic
  AuthName "http://unhosted.org/spec/dav/0.1"
  Require valid-user
  AuthUserFile ' . $passwdFilePath . '
</LimitExcept>';

		file_put_contents($scopeDir . '.htaccess', $htaccessContent);

		`htpasswd -bc $passwdFilePath $userId $token`;

		return $token;
	}
}