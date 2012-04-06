<?php
namespace examples;

require_once(dirname(__FILE__) . '/../Autoload.php');

use pumice\Pumice;
use pumice\Module;

class MyModule extends Module {
	
	public function configure() {
		$this->bind('Class')->to('Implementation')->in(self::SINGLETON);
	}
}

$injector = Pumice::createInjector(new MyModule());

?>