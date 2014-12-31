<?php

namespace mwijngaard\ArrayAbstraction;

use mwijngaard\ArrayAbstraction\Exception\NotSupportedOnObjectException;
use mwijngaard\ArrayAbstraction\Exception\NotSupportedOnTypeException;
use mwijngaard\ArrayAbstraction\Proxy\ProxyInterface;

class Utils {
	public static function offsetGet($val, $offset) {
		if (is_array($val)) {
			return $val[$offset];
		} else if (is_object($val)) {
			if ($val instanceof \ArrayAccess) {
				return $val[$offset];
			} else if ($val instanceof \Traversable) {
				foreach ($val as $current_offset => $value) {
					if ($current_offset === $offset) {
						return $value;
					}
				}
				trigger_error(sprintf("Undefined offset: %s", $offset), E_NOTICE);  // should this be an OutOfBoundsException?
				return null;
			} else {
				throw new NotSupportedOnObjectException($val);
			}
		} else {
			throw new NotSupportedOnTypeException($val);
		}
	}

	public static function offsetExists($val, $offset) {
		if (is_array($val)) {
			return isset($val[$offset]);
		} else if (is_object($val)) {
			if ($val instanceof \ArrayAccess) {
				return isset($val[$offset]);
			} else if ($val instanceof \Traversable) {
				foreach ($val as $key => $value) {
					if ($key === $offset && $value !== null) {
						return true;
					}
				}
				return false;
			} else {
				throw new NotSupportedOnObjectException($val);
			}
		} else {
			throw new NotSupportedOnTypeException($val);
		}
	}

	public static function offsetSet($val, $offset, $value) {
		if (is_array($val)) {
			$val[$offset] = $value;
		} else if (is_object($val)) {
			if ($val instanceof \ArrayAccess) {
				$val[$offset] = $value;
			} else {
				throw new NotSupportedOnObjectException($val);
			}
		} else {
			throw new NotSupportedOnTypeException($val);
		}
	}

	public static function offsetUnset($val, $offset) {
		if (is_array($val)) {
			unset($val[$offset]);
		} else if (is_object($val)) {
			if ($val instanceof \ArrayAccess) {
				unset($val[$offset]);
			} else {
				throw new NotSupportedOnObjectException($val);
			}
		} else {
			throw new NotSupportedOnTypeException($val);
		}
	}

	public static function getIterator($val) {
		if (is_array($val)) {
			return new \ArrayIterator($val);
		} else if (is_object($val)) {
			if ($val instanceof ProxyInterface) {
				return $val->getIterator();
			} else if ($val instanceof \Traversable) {
				return new \IteratorIterator($val);
			} else {
				throw new NotSupportedOnObjectException($val);
			}
		} else {
			throw new NotSupportedOnTypeException($val);
		}
	}

	public static function count($val) {
		if (is_array($val)) {
			return count($val);
		} else if (is_object($val)) {
			if ($val instanceof \Countable) {
				return count($val);
			} else if ($val instanceof \Traversable) {
				$ctr = 0;
				foreach ($val as $value) {
					$ctr++;
				}
				return $ctr;
			} else {
				throw new NotSupportedOnObjectException($val);
			}
		} else {
			throw new NotSupportedOnTypeException($val);
		}
	}

	public static function implode($glue, $val) {
		if (is_array($val)) {
			return implode($glue, $val);
		} else if (is_object($val)) {
			if ($val instanceof ProxyInterface) {
				return $val->implode($glue);
			} else if ($val instanceof \Traversable) {
				$pieces = iterator_to_array($val);
				return implode($glue, $pieces);
			} else {
				throw new NotSupportedOnObjectException($val);
			}
		} else {
			throw new NotSupportedOnTypeException($val);
		}
	}

	public static function changeKeyKase($val, $case = CASE_LOWER) {
		if (is_array($val)) {
			return array_change_key_case($val, $case);
		} else if (is_object($val)) {
			if ($val instanceof ProxyInterface) {
				return $val->changeKeyCase($case);
			} else if ($val instanceof \Traversable) {
				$array = iterator_to_array($val);
				return array_change_key_case($array, $case);
			} else {
				throw new NotSupportedOnObjectException($val);
			}
		} else {
			throw new NotSupportedOnTypeException($val);
		}
	}
}