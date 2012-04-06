<?php
/*
	Copyright (C) 2011 Dennis Sänger <mail@dennis.io>

	Licensed under the Apache License, Version 2.0 (the "License");
	you may not use this file except in compliance with the License.
	You may obtain a copy of the License at

	        http://www.apache.org/licenses/LICENSE-2.0

	Unless required by applicable law or agreed to in writing, software
	distributed under the License is distributed on an "AS IS" BASIS,
	WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
	See the License for the specific language governing permissions and
	limitations under the License.
*/
namespace pumice;

class BinderTest extends \PHPUnit_Framework_TestCase {

	private $uut;

	public function setUp() {
		$this->uut = new Binder();
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testInvalidBinding() {

		$binding = $this->uut->bind('SomeClassThatDoesNotExist');
	}

	public function testValidBinding() {

		$binding = $this->uut->bind('examples\SomeClass');

		$this->assertTrue(is_a($binding, 'pumice\Binding'));
		$this->assertTrue($this->uut->hasBinding('examples\SomeClass'));

	}

	public function testBindingAnnotation() {

		$binding = $this->uut->bindAnnotation('SomeString');

		$this->assertTrue(is_a($binding, 'pumice\Binding'));
		$this->assertTrue($this->uut->hasBinding('SomeString'));
	}

}
?>