<?php
namespace examples;

/**
 * @some value
*/
class SomeClass {

	/**
	 * @single("value")
	 * @array(["v1","v2"])
	 * @multiple({"int":1,"string":"foo"})
	 * @without
	 */
	public function method1() {
		return 'method1';
	}

	/**
	 * @SomeString("parameter1")
	 * @SomeOtherString("parameter2")
	 */
	public function method2($parameter1, $parameter2) {
		return 'method2: ' . $parameter1 . ' ' . $parameter2;
	}

}

class AnotherClass {

	private $some;

	public function __construct( SomeClass $some ) {
		$this->some = $some;
	}

	public function get() {
		return $this->some;
	}

}

?>