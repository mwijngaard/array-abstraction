<?php

namespace mwijngaard\ArrayAbstraction\Proxy;
use mwijngaard\ArrayAbstraction\Exception\NotSupportedOnObjectException;
use mwijngaard\ArrayAbstraction\Exception\NotSupportedOnTypeException;

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
    public function combine($values_val)
    {
        if (is_array($values_val)) {
            $values_array = $values_val;
        } elseif (is_object($values_val)) {
            if ($values_val instanceof ArrayProxy) {
                $values_array = $values_val->container;
            } elseif ($values_val instanceof ProxyInterface) {
                $values_array = $values_val->values();
            } elseif ($values_val instanceof \Traversable) {
                $values_array = iterator_to_array($values_val);
            } else {
                throw new NotSupportedOnObjectException($values_val);
            }
        } else {
            throw new NotSupportedOnTypeException($values_val);
        }

        return array_combine($this->container, $values_array);
    }

    public function diffAssoc($val2)
    {
        if (is_array($val2)) {
            $array2 = $val2;
        } elseif (is_object($val2)) {
            if ($val2 instanceof ArrayProxy) {
                $array2 = $val2->container;
            } elseif ($val2 instanceof ProxyInterface) {
                $array2 = $val2->values();
            } elseif ($val2 instanceof \Traversable) {
                $array2 = iterator_to_array($val2);
            } else {
                throw new NotSupportedOnObjectException($val2);
            }
        } else {
            throw new NotSupportedOnTypeException($val2);
        }

        return array_diff_assoc($this->container, $array2);
    }


    /**
     * @inherit
     */
    public function countValues()
    {
        return array_count_values($this->container);
    }



    /**
     * @inherit
     */
    public function values()
    {
        return array_values($this->container);
    }

}
