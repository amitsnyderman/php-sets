<?php

class Sets {
	const BOUND = 1000;

	public static function contains(callable $set, $elem) {
		return $set($elem);
	}

	public static function singletonSet($elem) {
		return function($x) use ($elem) {
			return $x == $elem;
		};
	}

	public static function union(callable $set1, callable $set2) {
		return function($x) use ($set1, $set2) {
			return $set1($x) || $set2($x);
		};
	}

	public static function intersect(callable $set1, callable $set2) {
		return function($x) use ($set1, $set2) {
			return $set1($x) && $set2($x);
		};
	}

	public static function diff(callable $set1, callable $set2) {
		return function($x) use ($set1, $set2) {
			return $set1($x) && !$set2($x);
		};
	}

	public static function filter(callable $set, callable $predicate) {
		return function($x) use ($set, $predicate) {
			return $set($x) && $predicate($x);
		};
	}

	public static function forall(callable $set, callable $predicate) {
		$iterate = function ($a) use (&$iterate, $set, $predicate) {
			if ($a > self::BOUND) return true;
			else if ($set($a)) return $predicate($a) && $iterate($a + 1);
			else return $iterate($a + 1);
		};
		return $iterate(-self::BOUND);
	}

	public static function exists(callable $set, callable $predicate) {
		return !Sets::forall($set, function($x) use ($predicate) {
			return !$predicate($x);
		});
	}

	public static function map(callable $set, callable $fn) {
		return function($x) use ($set, $fn) {
			return Sets::exists($set, function($y) use ($x, $fn) {
				return $fn($y) == $x;
			});
		};
	}

	public static function toString(callable $set) {
		$xs = array();
		for ($i = -self::BOUND; $i < self::BOUND; $i++) { 
			if (self::contains($set, $i)) {
				array_push($xs, $i);
			}
		}
		return sprintf('{%s}', implode(',', $xs));
	}

	public static function printSet(callable $set) {
		printf("%s\n", self::toString($set));
	}
}
