<?php
namespace examples;

class DataClass {
	
	public $value;

	/**
	 * @DefaultValueDataClass("value")
	 */
	public function __construct($value = null) {
		$this->value = $value;
	}

}