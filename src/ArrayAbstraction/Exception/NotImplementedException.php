<?php

namespace mwijngaard\ArrayAbstraction\Exception;

class NotImplementedException extends \LogicException
{
    public function __construct()
    {
        parent::__construct("This method is not implemented");
    }
}
