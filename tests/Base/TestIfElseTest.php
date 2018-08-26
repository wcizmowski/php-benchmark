<?php
/**
 * Created by PhpStorm.
 * User: webguru
 * Date: 26.08.18
 * Time: 15:52
 */

namespace Base;

use TestIfElse\TestIfElse;

require_once __DIR__ . '/../../Benchmark/TestIfElse.php';

class TestIfElseTest extends \PHPUnit_Framework_TestCase
{
    /**
     *  TestIfElse object creating
     */
    public function testReturnObject()
    {
        $testIfElse = new TestIfElse();

        $this->assertInternalType('object', $testIfElse);
    }

    /**
     * @depends testReturnObject
     */
    public function testNotEmptyResult()
    {
        $testIfElse = new TestIfElse();

        ob_start();
        $testIfElse->Test($result,1);
        ob_end_clean();

        $this->assertNotEquals($result, '');
        $this->assertArrayHasKey(TestIfElse::PARTS_BENCHMARK,$result);
        $this->assertArrayHasKey(TestIfElse::TEST_NAME,$result[TestIfElse::PARTS_BENCHMARK]);
    }
}
