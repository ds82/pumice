<?php
set_include_path(
	get_include_path() . PATH_SEPARATOR .
	dirname(__FILE__) . '/src' . PATH_SEPARATOR .
	dirname(__FILE__) . '/test' . PATH_SEPARATOR .
	dirname(__FILE__) . '/examples' . PATH_SEPARATOR .
	dirname(__FILE__) . '/lib/phannotation/src/phannotation'
);
function autoload($clazz) {
	$load = preg_replace('/\\\/', DIRECTORY_SEPARATOR, $clazz) . '.php';
	include_once($load);
}
spl_autoload_register('autoload');
?>