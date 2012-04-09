<?php
namespace examples;

use examples\DataClass;

class FirstClass {
	
	public $data;

	public function __construct( DataClass $data ) {
		$this->data = $data;
	}

	public function methodA() {
		return __CLASS__ . ' methodA';
	}

	public function methodB() {
		return __CLASS__ . ' methodB';
	}

	public function methodC() {
		return __CLASS__ .  ' methodC';
	}

}

?>