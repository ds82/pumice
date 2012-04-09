<?php
namespace examples;

use examples\FirstClass;


class SecondClass {
	
	public $c1;

	public function __construct( FirstClass $c1 ) {
		$this->c1 = $c1;
	}

	public function methodA() {
		return __CLASS__ .  ' methodA';
	}

	public function methodB() {
		return __CLASS__ .  ' methodB';
	}

	public function methodC() {
		return __CLASS__ .  ' methodC';
	}

}

?>