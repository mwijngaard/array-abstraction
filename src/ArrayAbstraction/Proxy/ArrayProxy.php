<?php

namespace mwijngaard\ArrayAbstraction\Proxy;

/**
 * Class ArrayProxy
 * @package mwijngaard\ArrayAbstraction\Proxy
 *
 * This class implements the proxy interface with a normal array backend. Use it to create new proxy classes which have
 * array backends and only override certain methods, falling back to the default implementations of this class.
 */
class ArrayProxy implements ProxyInterface
{
    protected $container;

    public function __construct(array $container = array())
    {
        $this->container = $container;
    }

    /**
     * @inherit
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * @inherit
     */
    public function offsetGet($offset)
    {
        return $this->container[$offset];
    }

    /**
     * @inherit
     */
    public function offsetSet($offset, $value)
    {
        $this->container[$offset] = $value;
    }

    /**
     * @inherit
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * @inherit
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->container);
    }

    /**
     * @inherit
     */
    public function count()
    {
        return count($this->container);
    }

    /**
     * @inherit
     */
    public function implode($glue)
    {
        return implode($glue, $this->container);
    }

    /**
     * @inherit
     */
    public function changeKeyCase($case = CASE_LOWER)
    {
        return new static(array_change_key_case($this->container, $case));
    }

    /**
     * @inherit
     */
    public function chunk($size, $preserve_keys = false)
    {
        return array_chunk($this->container, $size, $preserve_keys);
    }

    /**
     * @inherit
     */
    public function column($column_key, $index_key = null)
    {
        return array_column($this->container, $column_key, $index_key);
    }



    /**
     * @inherit
     */
    public function values()
    {
        return array_values($this->container);
    }

}
