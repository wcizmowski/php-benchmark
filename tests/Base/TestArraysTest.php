<?php

namespace Base;

use TestsArrays\TestArrays;

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
        $testMath = new TestArrays();

        $this->assertInternalType('object', $testMath);
    }

    /**
     * @depends testReturnObject
     */
    public function testNotEmptyResult()
    {
        $testMath = new TestArrays();

        ob_start();
        $testMath->Test($result,1);
        ob_end_clean();

        $this->assertNotEquals($result, '');
        $this->assertArrayHasKey(TestArrays::PARTS_BENCHMARK,$result);
        $this->assertArrayHasKey(TestArrays::TEST_NAME,$result[TestArrays::PARTS_BENCHMARK]);
    }
}