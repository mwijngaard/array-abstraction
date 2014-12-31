<?php

namespace mwijngaard\ArrayAbstraction\Exception;

class NotSupportedOnObjectException extends \InvalidArgumentException
{
    /**
     * @param object $obj
     */
    public function __construct($obj)
    {
        parent::__construct(sprintf("Not implemented for objects of class `%s`", get_class($obj)));
    }
}
