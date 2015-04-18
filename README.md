TypeHinting
===========
Quick fix for type hinting with PHP.

## Install
Composer:
```json
"gabrieljmj/phptypehinting": "dev-master"
```

## Usage
```php
use Gabrieljmj\PhpTypeHinting\TypeHinting;

TypeHinting::init();

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
will get
```
Fatal error: Uncaught exception 'InvalidArgumentException' with message 'Argument 1 passed to hello() must be string type, integer given' ...
```