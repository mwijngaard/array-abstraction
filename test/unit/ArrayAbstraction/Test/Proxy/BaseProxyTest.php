<?php

namespace mwijngaard\ArrayAbstraction\Test\Proxy;

use mwijngaard\ArrayAbstraction\Exception\NotImplementedException;
use mwijngaard\ArrayAbstraction\Proxy\BaseProxy;

class BaseProxyTest extends \PHPUnit_Framework_TestCase
{
    public function getMethodCalls()
    {
        return array(
            array('offsetExists', array(0)),
            array('offsetGet', array(0)),
            array('offsetSet', array(0, 1)),
            array('offsetUnset', array(0)),
            array('count', array()),
            array('getIterator', array()),
            array('implode', array(', ')),
            array('changeKeyCase', array(CASE_UPPER)),
            array('chunk', array(2, true)),
            array('column', array('age', 'name')),
        );
    }

    /**
     * @dataProvider getMethodCalls
     */
    public function testAllMethodsThrowNotImplementedException($name, $args)
    {
        $proxy = new BaseProxy();
        try {
            call_user_func_array(array($proxy, $name), $args);
            $this->fail("Expected NotImplementedException");
        } catch (NotImplementedException $e) {
        }
    }
}