<?php

namespace mwijngaard\ArrayAbstraction\Proxy;

use mwijngaard\ArrayAbstraction\Exception\NotImplementedException;

/**
 * Class BaseProxy
 * @package mwijngaard\ArrayAbstraction\Proxy
 *
 * This class implements all the methods of the proxy interface. Use it to create new proxy classes which do not have
 * array backends and only override the functionality you are interested in.
 */
class BaseProxy implements ProxyInterface
{
    /**
     * @inherit
     */
    public function offsetExists($offset)
    {
        throw new NotImplementedException();
    }

    /**
     * @inherit
     */
    public function offsetGet($offset)
    {
        throw new NotImplementedException();
    }

    /**
     * @inherit
     */
    public function offsetSet($offset, $value)
    {
        throw new NotImplementedException();
    }

    /**
     * @inherit
     */
    public function offsetUnset($offset)
    {
        throw new NotImplementedException();
    }

    /**
     * @inherit
     */
    public function count()
    {
        throw new NotImplementedException();
    }

    /**
     * @inherit
     */
    public function getIterator()
    {
        throw new NotImplementedException();
    }

    /**
     * @inherit
     */
    public function implode($glue)
    {
        throw new NotImplementedException();
    }

    /**
     * @inherit
     */
    public function changeKeyCase($case = CASE_LOWER)
    {
        throw new NotImplementedException();
    }
}
