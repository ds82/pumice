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
use phannotation\Phannotation;

class Pumice {

	private $binder;
	private $modules = array();

	private $reflectionCache = array();
	private $annotationClassCache = array();

	private function __construct( $modules ) {

		$this->binder = new Binder($this);

		foreach($modules AS $module) {
			if (!is_a($module, 'pumice\Module'))
				throw new InvalidArgumentException('given parameter is no Pumice-module');
			$this->modules[] = $module;
			call_user_func_array(array($module, 'setBinder'), array($this->binder));
			call_user_func(array($module, 'parentConfigure'));
		}

	}

	public static function createInjector() {
		return new Pumice(func_get_args());
	}

	private function getReflection( $clazz ) {
		
		if (is_object($clazz)) $key = get_class($clazz);
		else $key = $clazz;

		if (in_array($key, $this->reflectionCache))
			return $this->reflectionCache[$key];
		else {
			$reflection = new ReflectionClass($clazz);
			$this->reflectionCache[$key] = $reflection;
			return $reflection;
		}
	}

	private function getAnnotation( $clazz ) {

		if (is_object($clazz)) $key = get_class($clazz);
		else $key = $clazz;

		if (in_array($key, $this->annotationClassCache))
			return $this->annotationClassCache[$key];
		else {
			$annotation = new Phannotation($this->getReflection($clazz));
			$this->annotationClassCache[$key] = $annotation;
			return $annotation;
		}
	}

	public function getInstance( $clazz, $ignoreBinding = FALSE ) {
		
		//echo 'getInstance: ' . $clazz . PHP_EOL;
		if ($ignoreBinding || !$this->binder->hasBinding($clazz)) {
			//echo 'no binding for ' . $clazz . PHP_EOL;
			return $this->createInstance($clazz);
		} else {
			//echo 'found binding for ' . $clazz . PHP_EOL;
			return $this->binder->getBindingFor($clazz);
		}
	}

	private function createInstance( $clazz ) {

		if (!class_exists( $clazz )) {
			throw new InvalidArgumentException('Could not find class ' . $clazz);
		}

		//echo 'createInstance: ' . $clazz . PHP_EOL;
		$reflection = $this->getReflection($clazz);
		$constructor = $reflection->getConstructor();
		if ( $constructor === null || 0 === $constructor->getNumberOfParameters() )
			return $reflection->newInstance();
		else {
			$methodName = '__construct';
			// TODO do this only once per clazz
			$annotations = $this->getAnnotation($clazz)->constructor()->annotations();
			$this->binder->setAnnotations($clazz, $methodName, $annotations);

			$args = $this->instantiateParameter($clazz, $methodName, $constructor->getParameters());
			return $reflection->newInstanceArgs($args);
		}
	}

	public function instantiateParameter( $clazz, $method, $parameter ) {

		$args = array();
		foreach( $parameter AS $dep ) {
			$name = $dep->getName();
			if ($this->binder->hasAnnotationBinding($clazz,$method,$name)) {
				$args[] = $this->binder->getBindingForAnnotation($clazz,$method,$name);
			} else {
				$parameterClazz = $dep->getClass();
				if ($parameterClazz !== null && is_object($parameterClazz)) {
					$args[] = $this->getInstance($parameterClazz->getName());
				} else {
					$args[] = null;
				}
			}
		}
		return $args;
	}




}

?>