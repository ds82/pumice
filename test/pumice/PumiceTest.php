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

class ConcreteModule extends Module {
	
	private $binding;
	private $impl;
	private $singleton;

	public function __construct($binding, $impl, $singleton = FALSE) {
		$this->binding = $binding;
		$this->impl = $impl;
		$this->singleton = $singleton;
	}
	public function configure() {
		$binding = $this->bind($this->binding)->to($this->impl);
		if ($this->singleton) $binding->in(Scope::SINGLETON);
	}
}


class PumiceTest extends \PHPUnit_Framework_TestCase {

	private $module;

	public function setUp() {

		$this->module = $this->getMock('pumice\Module', array('setBinder', 'configure'));
	}

	public function testStaticConstruct() {
		
		$this->module->expects( $this->once() )
			->method( 'configure' );
		$this->module->expects( $this->once() )
			->method( 'setBinder' );
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
		$a = $uut->getInstance('examples\DataClass');
		$b = $uut->getInstance('examples\DataClass');

		$a->value = 10;
		$b->value = 20;

		$this->assertTrue(is_a($a, 'examples\DataClass'));
		$this->assertTrue(is_a($b, 'examples\DataClass'));
		$this->assertNotSame($a, $b);
		$this->assertEquals(10, $a->value);
		$this->assertEquals(20, $b->value);
	}

	public function testGetInstanceFromClassWithObjectBindingWithoutParameter() {

		$binding = 'examples\DataClass';

		$mock = new \examples\DataClass();
		$mock->value = 10;

		$module = new ConcreteModule($binding, $mock, TRUE);
		$uut = Pumice::createInjector($module);

		$data = $uut->getInstance('examples\DataClass');
		$this->assertEquals(10, $data->value);
	}

	public function testGetInstanceFromNonExistentClazzWithExistentBinding() {

		$bind = 'does\not\Exist';
		$impl = 'examples\DataClass';

		$module = new ConcreteModule($bind, $impl);
		$uut = Pumice::createInjector($module);

		$a = $uut->getInstance($bind);
		$this->assertTrue(is_a($a, $impl), 'assertion failed, class was: ' . get_class($a) . ' instead of ' . $impl);

		$a->value = 10;
		$b = $uut->getInstance($bind);
		$this->assertEquals(null, $b->value);
	}


}


?>