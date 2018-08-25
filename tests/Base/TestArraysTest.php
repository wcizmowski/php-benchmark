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
     */
    public function testReturnObject()
    {
        $testMath = new \TestsArrays\TestArrays();

        $this->assertInternalType('object', $testMath);
    }
}