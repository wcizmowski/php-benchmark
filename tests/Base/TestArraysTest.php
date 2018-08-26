<?php

namespace Base;

require_once __DIR__ . '/../../Benchmark/TestArrays.php';

/**
 * Class OffsetEncodingAlgorithmTest
 * @package Base
 */
class TestArraysTest extends \PHPUnit_Framework_TestCase
{
    /**
     *  TestArrays object creating
     */
    public function testReturnObject()
    {
        $testMath = new \TestsArrays\TestArrays();

        $this->assertInternalType('object', $testMath);
    }

    public function testNotEmptyResult()
    {
        $testMath = new \TestsArrays\TestArrays();

        ob_start();
        $testMath->Test($result,1);
        ob_end_clean();

        $this->assertNotEquals($result, '');
    }
}