<?php
namespace examples;

use examples\DataClass;

class ThirdClass {

	public $ref;

	public function __construct( DataClass $data ) {
		$this->ref = $data;
	}

}

?>