<?php
namespace examples;

class DataClass {
	
	public $value;

	/**
	 * @value("DefaultValueDataClass")
	 */
	public function __construct($value = null) {
		$this->value = $value;
	}

}