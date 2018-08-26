<?php
/**
 * Created by PhpStorm.
 * User: webguru
 * Date: 26.08.18
 * Time: 16:28
 */

namespace Base;

use TestString\TestString;

require_once __DIR__ . '/../../Benchmark/TestString.php';

class TestStringTest extends \PHPUnit_Framework_TestCase
{
    /**
     *  TestArrays object creating
     */
    public function testReturnObject()
    {
        $testString = new TestString();

        $this->assertInternalType('object', $testString);
    }

    /**
     * @depends testReturnObject
     */
    public function testNotEmptyResult()
    {
        $testString = new TestString();

        ob_start();
        $testString->Test($result,1);
        ob_end_clean();

        $this->assertNotEquals($result, '');
        $this->assertArrayHasKey(TestString::PARTS_BENCHMARK,$result);
        $this->assertArrayHasKey(TestString::TEST_NAME,$result[TestString::PARTS_BENCHMARK]);
    }
}
