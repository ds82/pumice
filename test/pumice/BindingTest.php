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

use pumice\Scope;

class BindingTest extends \PHPUnit_Framework_TestCase {

	private $injector;

	public function setUp() {
		$this->injector = 
			$this->getMock('pumice\Pumice', array('getInstance'), array(), '', false);		
	}

	public function testSingletonScopeBinding() {

		$mock = new \stdClass();
		$mock->value = 1;
		
		$uut = new Binding($this->injector);
		$uut->to($mock)->in(Scope::SINGLETON);

		$this->assertTrue($uut->is(Binding::INSTANCE));
		$this->assertEquals($mock, $uut->get($mock));
		$this->assertEquals(1, $uut->get($mock)->value);
	}

	public function testSingletonScopeBindingWithClassAndStubInjector() {

		$clazz = 'examples\DataClass';
		$instance = new \examples\DataClass();

		$this->injector->expects( $this->once() )
			->method( 'getInstance' )
			->with( $this->equalTo($clazz) )
			->will( $this->returnValue($instance) );

		$uut = new Binding($this->injector);
		$uut->to($clazz)->in(Scope::SINGLETON);

		$this->assertTrue($uut->is(Binding::CLAZZ));
		
		$a = $uut->get($clazz);
		$this->assertTrue(is_a($a, $clazz));
		$a->value = 10;

		$b = $uut->get($clazz);
		$this->assertEquals(10, $b->value);
	}

}
?>