<?php

require 'lib/Sets.php';

class SetsTest extends PHPUnit_Framework_TestCase {

	function testContains() {
		$evens = function($x) {
			return $x % 2 === 0;
		};

		$this->assertFalse(Sets::contains($evens, 1));
		$this->assertTrue(Sets::contains($evens, 2));
	}

	function testSingletonSet() {
		$s = Sets::singletonSet(1);

		$this->assertTrue(Sets::contains($s, 1));
		$this->assertFalse(Sets::contains($s, 2));
	}

	function testUnion() {
		$s1 = Sets::singletonSet(1);
		$s2 = Sets::singletonSet(2);
		$u = Sets::union($s1, $s2);

		$this->assertTrue(Sets::contains($u, 1));
		$this->assertTrue(Sets::contains($u, 2));
		$this->assertFalse(Sets::contains($u, 3));
	}

	function testIntersect() {
		$s1 = Sets::singletonSet(1);
		$s2 = Sets::singletonSet(2);
		$s3 = Sets::singletonSet(3);
		$u1 = Sets::union($s1, $s2);
		$u2 = Sets::union($s2, $s3);
		$i = Sets::intersect($u1, $u2);

		$this->assertFalse(Sets::contains($i, 1));
		$this->assertTrue(Sets::contains($i, 2));
		$this->assertFalse(Sets::contains($i, 3));
	}

	function testDiff() {
		$s1 = Sets::singletonSet(1);
		$s2 = Sets::singletonSet(2);
		$s3 = Sets::singletonSet(3);
		$u1 = Sets::union($s1, $s2);
		$u2 = Sets::union($s2, $s3);
		$d = Sets::diff($u1, $u2);

		$this->assertTrue(Sets::contains($d, 1));
		$this->assertFalse(Sets::contains($d, 2));
		$this->assertFalse(Sets::contains($d, 3));
	}

	function testFilter() {
		$s1 = Sets::singletonSet(1);
		$s2 = Sets::singletonSet(2);
		$u = Sets::union($s1, $s2);

		$fn = function($x) {
			return $x % 2 !== 0;
		};

		$f = Sets::filter($u, $fn);

		$this->assertTrue(Sets::contains($f, 1));
		$this->assertFalse(Sets::contains($f, 2));
	}

	function testForall() {
		$s1 = Sets::singletonSet(1);
		$s2 = Sets::singletonSet(2);
		$u = Sets::union($s1, $s2);

		$fn1 = function($x) {
			return $x < 3;
		};

		$fn2 = function($x) {
			return $x < 2;
		};

		$this->assertTrue(Sets::forall($u, $fn1));
		$this->assertFalse(Sets::forall($u, $fn2));
	}

	function testExists() {
		$s1 = Sets::singletonSet(1);
		$s2 = Sets::singletonSet(2);
		$u = Sets::union($s1, $s2);

		$fn1 = function($x) {
			return $x < 3;
		};

		$fn2 = function($x) {
			return $x < 2;
		};

		$fn3 = function($x) {
			return $x > 3;
		};

		$this->assertTrue(Sets::exists($u, $fn1));
		$this->assertTrue(Sets::exists($u, $fn2));
		$this->assertFalse(Sets::exists($u, $fn3));
	}

	function testMap() {
		$s1 = Sets::singletonSet(1);
		$s2 = Sets::singletonSet(2);
		$u = Sets::union($s1, $s2);

		$m = Sets::map($u, function($x) {
			return $x * 10;
		});

		$this->assertTrue(Sets::contains($m, 10));
		$this->assertTrue(Sets::contains($m, 20));
		$this->assertFalse(Sets::contains($m, 1));
		$this->assertFalse(Sets::contains($m, 2));
	}
}
