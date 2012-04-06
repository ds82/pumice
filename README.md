# Pumice #

A dependency injection container for PHP with (not implemented ;) ) annoation support.
Pumice is heavly inspired by [Google's Gucie](http://code.google.com/p/google-guice/) for Java. If you have already worked with Guice, you'll feel familiar with Pumice's syntax.

This project is in early stage of its development, use it with care!

# Quick Example #

```php
class MyModule extends Module {
	
	public function configure() {
		$this->bind('some\Data')->to('examples\DataClass')->in(Scope::SINGLETON);
	}
}
$injector = Pumice::createInjector(new MyModule());
$data = $injector->getInstance('some\Data');
```

For more examples look at the [phpunit-tests](https://github.com/ds82/pumice/tree/master/test/pumice).

