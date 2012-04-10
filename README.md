# Pumice #

A dependency injection container for PHP with annoation support.
Pumice is heavly inspired by [Google's Gucie](http://code.google.com/p/google-guice/) for Java. If you have already worked with Guice, you'll feel familiar with Pumice's syntax.

This project is in early stage of its development, use it with care!

# Quick Example #

```php
namespace foo;

class A {

	public $value;
	/**
	 * @DefaultValue("value")
	 */
	public function __construct($value = null) {
		$this->value = $value;
	}
}
```

```php
namespace foo;

use foo\A;

class B {
	
	public $a;

	public function __construct(A $a) {
		$this->a = $a;
	}
}
```

```php
class MyModule extends Module {
	
	public function configure() {
		$this->bind('some\X')->to('foo\B')->in(Scope::SINGLETON);
		$this->bindAnnotation('DefaultValue')->toValue(1000);
	}
}
$injector = Pumice::createInjector(new MyModule());
$b = $injector->getInstance('some\X');

$this->assertEquals(1000, $b->a->value);

```



For more examples look at the [phpunit-tests](https://github.com/ds82/pumice/tree/master/test/pumice).

