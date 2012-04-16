<?php

class ProviderExample {

	public $d1;
	public $d2;
	public $d3;

	/**
	 * @Provider(["dataProvider", "examples\DataClass"])
	 */
	public function __construct($dataProvider) {
		$this->d1 = $dataProvider.get();
		$this->d2 = $dataProvider.get();
		$this->d3 = $dataProvider.get();
	}

}


?>