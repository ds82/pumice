<?php
namespace examples;

use examples\SecondClass;
use examples\FirstClass;

class ThirdClass {

	public $c1;
	public $c2;

	public function __construct( FirstClass $c1, SecondClass $c2 ) {

		$this->c1 = $c1;
		$this->c2 = $c2;
	}

}

?>