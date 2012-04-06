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

class Binding {
	
	const CLAZZ = 1;
	const INSTANCE = 2;

	private $scope;
	private $binding;
	private $is;

	public function to( $impl ) {
		
		$this->examine($impl);
		$this->binding = $impl;
		$this->scope = new Scope( $impl );
		return $this->scope;
	}

	private function examine( $impl ) {

		if (is_object($impl) && !is_string($impl))
			$this->is = self::INSTANCE;
		else if (is_string($impl) && !is_object($impl))
			$this->is = self::CLAZZ;
		else throw new InvalidArgumentException('Invalid argument passed to Binding->to(): ' . var_export($impl));
	}

	public function get() {
		return $this->binding;
	}

	public function scope() {
		return $this->scope;
	}

	public function is( $is ) {
		return $this->is === $is;
	}

}