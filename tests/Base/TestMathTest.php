<?php
/**
 * Created by PhpStorm.
 * User: webguru
 * Date: 26.08.18
 * Time: 16:25
 */

namespace Base;

use TestMath\TestMath;

require_once __DIR__ . '/../../Benchmark/TestMath.php';

class TestMathTest extends \PHPUnit_Framework_TestCase
{
    /**
     *  TestMath object creating
     */
    public function testReturnObject()
    {
        $testMath = new TestMath();

        $this->assertInternalType('object', $testMath);
    }

    /**
     * @depends testReturnObject
     */
    public function testNotEmptyResult()
    {
        $testMath = new TestMath();

        ob_start();
        $testMath->Test($result,1);
        ob_end_clean();

        $this->assertNotEquals($result, '');
        $this->assertArrayHasKey(TestMath::PARTS_BENCHMARK,$result);
        $this->assertArrayHasKey(TestMath::TEST_NAME,$result[TestMath::PARTS_BENCHMARK]);
    }
}
