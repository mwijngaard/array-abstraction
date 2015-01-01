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
     * @return array
     */
    public function changeKeyCase($case = CASE_LOWER);

    /**
     * Split into chunks
     *
     * @param int $size
     * @param bool $preserve_keys
     * @return array
     */
    public function chunk($size, $preserve_keys = false);

    /**
     * Return the values from a single column
     *
     * @param mixed $column_key
     * @param mixed $index_key
     * @return array
     */
    public function column($column_key, $index_key = null);

    /**
     * Counts all the values of an array
     *
     * @return int[]
     */
    public function countValues();

    /**
     * Return all values (reindexed)
     *
     * @return array
     */
    public function values();
}
