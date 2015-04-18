TypeHinting
===========
Using type hinting with PHP. <br />
Recommendation: don't use it.

## Usage
```php
<?php
require_once 'TypeHinting.php';

function hello(string $name) {
    echo 'Hello ' . $name;
}

hello('Gabriel');
```

will return

```
Hello Gabriel
```
but
```php
hello(87);
```
will trigger
```
Fatal error: Uncaught exception 'InvalidArgumentException' with message 'Argument 1 passed to hello() must be string type, integer given' ...
```