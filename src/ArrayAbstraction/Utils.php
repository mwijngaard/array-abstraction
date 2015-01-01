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
    /**
     * Whether a offset exists
     *
     * @param array|\ArrayAccess|\Traversable $val
     * @param $offset
     * @return bool
     */
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

    /**
     * Offset to retrieve
     *
     * @param array|\ArrayAccess|\Traversable $val
     * @param mixed $offset
     * @return mixed
     */
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
                // Should this be an OutOfBoundsException?
                trigger_error(sprintf("Undefined offset: %s", $offset), E_NOTICE);
                return null;
            } else {
                throw new NotSupportedOnObjectException($val);
            }
        } else {
            throw new NotSupportedOnTypeException($val);
        }
    }

    /**
     * Offset to set
     *
     * @param array|\ArrayAccess $val
     * @param mixed $offset
     * @param mixed $value
     */
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

    /**
     * Offset to unset
     *
     * @param array|\ArrayAccess $val
     * @param mixed $offset
     */
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

    /**
     * Retrieve an external iterator
     *
     * @param array|\Traversable $val
     * @return \Traversable
     */
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

    /**
     * Count elements of an object
     *
     * @param array|\Countable|\Traversable $val
     * @return int
     */
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

    /**
     * Join array elements with a string
     *
     * @param string $glue
     * @param array|\Traversable $val
     * @return string
     */
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

    /**
     * Changes the case of all keys in an array
     *
     * @param array|\Traversable $val
     * @param int $case
     * @return array
     */
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

    /**
     * Split an array into chunks
     *
     * @param array|\Traversable $val
     * @param int $size
     * @param bool $preserve_keys
     * @return array
     */
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

    /**
     * Return the values from a single column in the input array
     *
     * @param array|\Traversable $val
     * @param mixed $column_key
     * @param mixed $index_key
     * @return array
     */
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

    /**
     * Creates an array by using one array for keys and another for its values
     *
     * @param array|\Traversable $keys_val
     * @param array|\Traversable $values_val
     * @return array
     */
    public static function combine($keys_val, $values_val)
    {
        if (is_array($keys_val)) {
            $keys_array = $keys_val;
        } elseif (is_object($keys_val)) {
            if ($keys_val instanceof ProxyInterface) {
                $keys_array = $keys_val->values();
            } elseif ($keys_val instanceof \Traversable) {
                $keys_array = iterator_to_array($keys_val);
            } else {
                throw new NotSupportedOnObjectException($keys_val);
            }
        } else {
            throw new NotSupportedOnTypeException($keys_val);
        }

        if (is_array($values_val)) {
            $values_array = $values_val;
        } elseif (is_object($values_val)) {
            if ($values_val instanceof ProxyInterface) {
                $values_array = $values_val->values();
            } elseif ($values_val instanceof \Traversable) {
                $values_array = iterator_to_array($values_val);
            } else {
                throw new NotSupportedOnObjectException($values_val);
            }
        } else {
            throw new NotSupportedOnTypeException($values_val);
        }

        return array_combine($keys_array, $values_array);
    }

    /**
     * @param array|\Traversable $val
     * @return array
     */
    public static function countValues($val)
    {
        if (is_array($val)) {
            $array = $val;
        } elseif (is_object($val)) {
            if ($val instanceof ProxyInterface) {
                return $val->countValues();
            } elseif ($val instanceof \Traversable) {
                $array = iterator_to_array($val);
            } else {
                throw new NotSupportedOnObjectException($val);
            }
        } else {
            throw new NotSupportedOnTypeException($val);
        }

        return array_count_values($array);
    }



    public static function values($val)
    {
        if (is_array($val)) {
            $array = $val;
        } elseif (is_object($val)) {
            if ($val instanceof ProxyInterface) {
                return $val->values();
            } elseif ($val instanceof \Traversable) {
                $array = iterator_to_array($val);
            } else {
                throw new NotSupportedOnObjectException($val);
            }
        } else {
            throw new NotSupportedOnTypeException($val);
        }

        return array_values($array);
    }

}
