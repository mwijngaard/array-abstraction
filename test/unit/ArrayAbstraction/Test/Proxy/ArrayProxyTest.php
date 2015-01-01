<?php

namespace mwijngaard\ArrayAbstraction\Test\Proxy;

use mwijngaard\ArrayAbstraction\Proxy\ArrayProxy;

class ArrayProxyTest extends \PHPUnit_Framework_TestCase
{
    public function getMethodCalls()
    {
        $numeric_key_array = array('a', 'b', 'c');
        $string_key_array = array('a' => 0, 'b' => 1, 'c' => 2);

        return array(
            array($numeric_key_array, 'offsetExists', array(1), true),
            array($numeric_key_array, 'offsetGet', array(1), 'b'),
            array($numeric_key_array, 'count', array(), 3),
            array($numeric_key_array, 'getIterator', array(), new \ArrayIterator($numeric_key_array)),
            array($numeric_key_array, 'implode', array(''), 'abc'),
            array($string_key_array, 'changeKeyCase', array(CASE_UPPER), new ArrayProxy(array(
                'A' => 0,
                'B' => 1,
                'C' => 2
            ))),
            array($numeric_key_array, 'chunk', array(2), array(
                array('a', 'b'),
                array('c')
            )),
            array(array(
                array(
                    'age' => 23,
                    'name' => 'John'
                ),
                array(
                    'age' => 22,
                    'name' => 'Jane'
                ),
            ), 'column', array('age', 'name'), array(
                'John' => 23,
                'Jane' => 22
            )),
            array($string_key_array, 'values', array(), array(0, 1, 2))
        );
    }

    /**
     * @dataProvider getMethodCalls
     */
    public function testNonModifyingMethodCalls(
        $array,
        $name,
        $args,
        $expected_ret,
        \Exception $expected_exception = null
    ) {
        $proxy = new ArrayProxy($array);
        try {
            $ret = call_user_func_array(array($proxy, $name), $args);
            if ($expected_exception !== null) {
                $this->fail(sprintf("Expected exception of type `%s`", get_class($expected_exception)));
            }
            $this->assertEquals($expected_ret, $ret);
        } catch (\Exception $e) {
            $this->assertEquals($expected_exception, $e);
        }
    }

    public function testSet()
    {
        $proxy = new ArrayProxy(array('a', 'b', 'c'));
        $new_value = 'B';
        $proxy[1] = $new_value;
        $this->assertEquals($new_value, $proxy[1]);
    }

    public function testUnset()
    {
        $proxy = new ArrayProxy(array('a', 'b', 'c'));
        unset($proxy[1]);
        $this->assertFalse(isset($proxy[1]));
    }
}