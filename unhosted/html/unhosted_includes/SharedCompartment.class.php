<?php

class Unhosted_SharedCompartment {
	private $name = '';
	private $userId = '';
	private $scope = '';

	private $info = array();
	private $exists = false;

	public function __construct($sharedCompartmentName, $userId, $scope = null) {
		$this->name = Unhosted_SharedCompartment::normalizeSharedCompartmentName($sharedCompartmentName);
		$this->userId = $userId;
		$this->scope = $scope;
	}

	public static function normalizeSharedCompartmentName($compartment) {
		return Unhosted::normalizeScopeName($compartment);
	}

	private function getMasterPath() {
		return Unhosted::getScopeDavPath($this->userId, 'sharedCompartments') . $this->name . '/';
	}

	private function getScopePath($includingTrailingSlash = true) {
		return Unhosted::getScopeDavPath($this->userId, $this->scope) . $this->name . ($includingTrailingSlash ? '/' : '');
	}

	private function getInfoFilePath() {
		return $this->getMasterPath() . '/.info.json';
	}

	public function readInfo() {
		$infoFilePath = $this->getInfoFilePath();

		if(!file_exists($infoFilePath)) {
			$this->exists = false;
			$this->info = array(
				'creator' => '',
				'usages' => array()
			);
		} else {
			$this->exists = true;
			$info = json_decode(file_get_contents($infoFilePath), true);
			$this->info = $info;
		}
	}

	public function getInfo() {
		return $this->info;
	}

	public function getExists() {
		return $this->exists;
	}

	private function writeInfo() {
		$infoFilePath = $this->getInfoFilePath();

		file_put_contents($infoFilePath, json_encode($this->info));
	}

	public function register() {
		$masterPath = $this->getMasterPath();
		if(!is_dir($masterPath)) {
			mkdir($masterPath, 0777, true);
		}

		$scopePath = $this->getScopePath(false);
		if(!file_exists($scopePath)) {
			symlink($masterPath, $scopePath);
		}

		$this->readInfo();
		if(!@$this->info['creator']) {
			$this->info['creator'] = $this->scope;
		}
		
		if(!in_array($this->scope, $this->info['usages'])) {
			$this->info['usages'][] = $this->scope;
		}

		$this->writeInfo();
	}

}