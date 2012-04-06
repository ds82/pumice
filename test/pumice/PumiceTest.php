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

class PumiceTest extends \PHPUnit_Framework_TestCase {

	private $module;

	public function setUp() {

		$this->module = $this->getMock('pumice\Module', array('setBinder', 'configure'));
		$this->module->expects( $this->once() )
			->method( 'configure' );
		$this->module->expects( $this->once() )
			->method( 'setBinder' );

	}

	public function testStaticConstruct() {
		
		$uut = Pumice::createInjector($this->module);
	}

	public function testGetInstanceFromClassWithoutBindingAndWithoutParameter() {

		$uut = Pumice::createInjector($this->module);
		$some = $uut->getInstance('examples\SomeClass');

		$this->assertTrue(is_a($some, 'examples\SomeClass'));
		$this->assertEquals('method1', call_user_func(array($some, 'method1')));
	}

	public function testGetInstanceFromClassWithoutBindingButParameter() {

		$uut = Pumice::createInjector($this->module);
		$some = $uut->getInstance('examples\AnotherClass');

		$this->assertTrue(is_a($some, 'examples\AnotherClass'));

	}


}


?>