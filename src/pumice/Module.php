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

abstract class Module {
	
	const SINGLETON = 1;

	private $binder;

	function setBinder($binder) {
		$this->binder = $binder;
	}

	public function bind($arg) {
		return $this->binder->bind($arg);
	}

	public function bindAnnotation( $annotation ) {
		return $this->binder->bindAnnotation($annotation);
	}

	public abstract function configure();
}

?>