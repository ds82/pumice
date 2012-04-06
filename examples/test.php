<?php
namespace examples;

require_once(dirname(__FILE__) . '/../Autoload.php');

use pumice\Pumice;
use pumice\Module;
use pumice\Scope;

class MyModule extends Module {
	
	public function configure() {
		$this->bind('some\Data')->to('examples\DataClass')->in(Scope::SINGLETON);
	}
}

$injector = Pumice::createInjector(new MyModule());

$a = $injector->getInstance('some\Data');
$a->value = 10;

$b = $injector->getInstance('some\Data');
echo $b->value;


?>