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

use \InvalidArgumentException;
use \ReflectionClass;
use pumice\Module;

class Pumice {

	private $binder;
	private $modules = array();

	private function __construct( $modules ) {

		$this->binder = new Binder($this);

		foreach($modules AS $module) {
			if (!is_a($module, 'pumice\Module'))
				throw new InvalidArgumentException('given parameter is no Pumice-module');
			$this->modules[] = $module;
			call_user_func_array(array($module, 'setBinder'), array($this->binder));
			call_user_func(array($module, 'configure'));
		}

	}

	public static function createInjector() {
		return new Pumice(func_get_args());
	}

	public function getInstance( $clazz ) {
		
		if (!class_exists( $clazz ))
			throw new InvalidArgumentException('Could not find class: ' . $clazz);
		
		if (!$this->binder->hasBinding($clazz)) {
			return $this->createInstance($clazz);
		} else {
			return $this->binder->getBindingFor($clazz);
		}
	}

	private function createInstance( $clazz ) {
		
		$reflection = new ReflectionClass($clazz);
		$constructor = $reflection->getConstructor();
		if ( $constructor === null || 0 === $constructor->getNumberOfParameters() )
			return $reflection->newInstance();
		else {
			$args = $this->instantiateParameter($constructor->getParameters());
			return $reflection->newInstanceArgs($args);
		}
	}

	public function instantiateParameter( $parameter ) {

		$args = array();
		foreach( $parameter AS $dep ) {
			$args[] = $this->createInstance($dep->getClass()->getName());
		}
		return $args;
	}




}

?>