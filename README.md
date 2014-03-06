# PHP Sets

Port of the sets assignment from the Coursera Functional Programming Scala course. Operations for working with an integer set of unknown size in a functional way. A set is simply a function whose input is an integer and output is a boolean.

## Usage

Define sets of integers via predicates.

```php
$evens = function($x) {
	return $x % 2 === 0;
};

Sets::contains($evens, 1); // false
Sets::contains($evens, 2); // true
```

See [tests](tests/SetsTest.php) for more examples.

## Test

```
% phpunit tests/SetsTest.php 
```