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

    /**
     * Split into chunks
     *
     * @param int $size
     * @param bool $preserve_keys
     * @return mixed
     */
    public function chunk($size, $preserve_keys = false);

    /**
     * Return the values from a single column
     *
     * @param mixed $column_key
     * @param mixed $index_key
     * @return mixed[]
     */
    public function column($column_key, $index_key = null);



    /**
     * Return all values (reindexed)
     *
     * @return mixed[]
     */
    public function values();
}
