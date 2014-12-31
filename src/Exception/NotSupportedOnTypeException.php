<?php

namespace mwijngaard\ArrayAbstraction\Exception;

class NotSupportedOnTypeException extends \InvalidArgumentException {
	/**
	 * @param mixed $val
	 */
	public function __construct($val) {
		parent::__construct(sprintf("Not implemented for values of type `%s`", gettype($val)));
	}
}