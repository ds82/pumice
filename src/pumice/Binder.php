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
use pumice\Binding;

class Binder {

	private $injector;
	private $binds = array();

	public function __construct(Pumice $injector) {
		$this->injector = $injector;
	}

	public function hasBinding( $binding ) {
		return array_key_exists($binding, $this->binds);
	}

	public function bind( $clazz ) {
		
		if (!class_exists($clazz))
			throw new InvalidArgumentException('You tried to bind a class that does not exist: ' . $clazz);

		$binding = new Binding($this->injector);
		$this->binds[$clazz] = $binding;
		return $binding;
	}

	public function bindAnnotation( $annoation ) {

		$binding = new Binding($this->injector);
		$this->binds[$annoation] = $binding;
		return $binding;
	}

	public function getBindingFor( $clazz ) {

		$binding = $this->binds[$clazz];

		if ($binding->scope()->is(Scope::SINGLETON))
			return $binding->get();
	}



}

?>