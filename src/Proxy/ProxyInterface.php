<?php

namespace mwijngaard\ArrayAbstraction\Proxy;

interface ProxyInterface extends \ArrayAccess, \IteratorAggregate, \Countable
{
    /**
     * Join elements with a string
     *
     * @param string $glue
     * @return string
     */
    public function implode($glue);

    /**
     * Changes the case of all keys
     *
     * @param $case
     * @return mixed
     */
    public function changeKeyCase($case = CASE_LOWER);
}
