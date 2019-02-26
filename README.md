# Get class names

This package can get the name of the base class, the namespace, the canonical name, the parent class name, and the path of an object.
It can have as a parameter a string as a class name or an object to get its class.

This class was nominated for the [Innovation award](https://www.phpclasses.org/award/innovation/) from [phpclasses.org](https://www.phpclasses.org)

[LooK Here - https://www.phpclasses.org/package/10819-PHP-Get-the-base-class-name-and-namespace-of-an-object.html](https://www.phpclasses.org/package/10818-PHP-Manipulate-directories-files-and-their-contents.html)

### Installation

Install the latest version with

```bash
$ composer require laudirbispo/classname
```

### Basic Usage

```php
<?php

use laudirbispo\classname\ClassName;

$exampleClass = 'namespace\namspace2\MyClass';
// or
$exampleClass = new MyClass;

var_dump(ClassName::full($exampleClass));
// return string 'namespace\namspace2\MyClass' (length=27)

var_dump(ClassName::namespace($exampleClass));
// return string 'namespace\namspace2' (length=19)

var_dump(ClassName::short($exampleClass));
//return string 'MyClass' (length=7)

var_dump(ClassName::canonical($exampleClass));
// return string 'namespace.namspace2.MyClass' (length=27)

// Get parent class name or null
// @param $return string - full, namespace, canonical short - default is dull
var_dump(ClassName::getParent($exampleClass, string $return = 'full'));


```

### Author

Laudir Bispo - <laudirbispo@outlook.com> - <https://twitter.com/laudir_bispo><br />

### License

ClassName is licensed under the MIT License - see the `LICENSE` file for details
**Free Software, Hell Yeah!**
