<?php

namespace mwijngaard\ArrayAbstraction;

use mwijngaard\ArrayAbstraction\Exception\NotSupportedOnObjectException;
use mwijngaard\ArrayAbstraction\Exception\NotSupportedOnTypeException;
use mwijngaard\ArrayAbstraction\Proxy\ProxyInterface;

/**
 * Class Utils
 * @package mwijngaard\ArrayAbstraction
 *
 * Contains all the array-related functionality that we're trying to replace.
 */
class Utils
{
    public static function offsetGet($val, $offset)
    {
        if (is_array($val)) {
            return $val[$offset];
        } elseif (is_object($val)) {
            if ($val instanceof \ArrayAccess) {
                return $val[$offset];
            } elseif ($val instanceof \Traversable) {
                foreach ($val as $current_offset => $value) {
                    if ($current_offset === $offset) {
                        return $value;
                    }
                }
                // TODO: should this be an OutOfBoundsException?
                trigger_error(sprintf("Undefined offset: %s", $offset), E_NOTICE);
                return null;
            } else {
                throw new NotSupportedOnObjectException($val);
            }
        } else {
            throw new NotSupportedOnTypeException($val);
        }
    }

    public static function offsetExists($val, $offset)
    {
        if (is_array($val)) {
            return isset($val[$offset]);
        } elseif (is_object($val)) {
            if ($val instanceof \ArrayAccess) {
                return isset($val[$offset]);
            } elseif ($val instanceof \Traversable) {
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

    public static function offsetSet($val, $offset, $value)
    {
        if (is_array($val)) {
            $val[$offset] = $value;
        } elseif (is_object($val)) {
            if ($val instanceof \ArrayAccess) {
                $val[$offset] = $value;
            } else {
                throw new NotSupportedOnObjectException($val);
            }
        } else {
            throw new NotSupportedOnTypeException($val);
        }
    }

    public static function offsetUnset($val, $offset)
    {
        if (is_array($val)) {
            unset($val[$offset]);
        } elseif (is_object($val)) {
            if ($val instanceof \ArrayAccess) {
                unset($val[$offset]);
            } else {
                throw new NotSupportedOnObjectException($val);
            }
        } else {
            throw new NotSupportedOnTypeException($val);
        }
    }

    public static function getIterator($val)
    {
        if (is_array($val)) {
            return new \ArrayIterator($val);
        } elseif (is_object($val)) {
            if ($val instanceof \IteratorAggregate) {
                return $val->getIterator();
            } elseif ($val instanceof \Traversable) {
                return new \IteratorIterator($val);
            } else {
                throw new NotSupportedOnObjectException($val);
            }
        } else {
            throw new NotSupportedOnTypeException($val);
        }
    }

    public static function count($val)
    {
        if (is_array($val)) {
            $var = $val;
        } elseif (is_object($val)) {
            if ($val instanceof \Countable) {
                $var = $val;
            } elseif ($val instanceof \Traversable) {
                return iterator_count($val);
            } else {
                throw new NotSupportedOnObjectException($val);
            }
        } else {
            throw new NotSupportedOnTypeException($val);
        }

        return count($var);
    }

    public static function implode($glue, $val)
    {
        if (is_array($val)) {
            $array = $val;
        } elseif (is_object($val)) {
            if ($val instanceof ProxyInterface) {
                return $val->implode($glue);
            } elseif ($val instanceof \Traversable) {
                $array = iterator_to_array($val);
            } else {
                throw new NotSupportedOnObjectException($val);
            }
        } else {
            throw new NotSupportedOnTypeException($val);
        }

        return implode($glue, $array);
    }

    public static function changeKeyKase($val, $case = CASE_LOWER)
    {
        if (is_array($val)) {
            $array = $val;
        } elseif (is_object($val)) {
            if ($val instanceof ProxyInterface) {
                return $val->changeKeyCase($case);
            } elseif ($val instanceof \Traversable) {
                $array = iterator_to_array($val);
            } else {
                throw new NotSupportedOnObjectException($val);
            }
        } else {
            throw new NotSupportedOnTypeException($val);
        }

        return array_change_key_case($array, $case);
    }

    public static function chunk($val, $size, $preserve_keys = false)
    {
        if (is_array($val)) {
            $array = $val;
        } elseif (is_object($val)) {
            if ($val instanceof ProxyInterface) {
                return $val->chunk($size, $preserve_keys);
            } elseif ($val instanceof \Traversable) {
                $array = iterator_to_array($val);
            } else {
                throw new NotSupportedOnObjectException($val);
            }
        } else {
            throw new NotSupportedOnTypeException($val);
        }

        return array_chunk($array, $size, $preserve_keys);
    }

    public static function column($val, $column_key, $index_key = null)
    {
        if (is_array($val)) {
            $array = $val;
        } elseif (is_object($val)) {
            if ($val instanceof ProxyInterface) {
                return $val->column($column_key, $index_key);
            } elseif ($val instanceof \Traversable) {
                $array = iterator_to_array($val);
            } else {
                throw new NotSupportedOnObjectException($val);
            }
        } else {
            throw new NotSupportedOnTypeException($val);
        }

        return array_column($array, $column_key, $index_key);
    }
}
