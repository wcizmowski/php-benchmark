<?php
/**
 * Created by PhpStorm.
 * User: webguru
 * Date: 26.08.18
 * Time: 16:04
 */

namespace Base;

use TestLoops\TestLoops;

require_once __DIR__ . '/../../Benchmark/TestLoops.php';

class TestLoopsTest extends \PHPUnit_Framework_TestCase
{
    /**
     *  TestLoops object creating
     */
    public function testReturnObject()
    {
        $testLoops = new TestLoops();

        $this->assertInternalType('object', $testLoops);
    }

    /**
     * @depends testReturnObject
     */
    public function testNotEmptyResult()
    {
        $testLoops = new TestLoops();

        ob_start();
        $testLoops->Test($result,1);
        ob_end_clean();

        $this->assertNotEquals($result, '');
        $this->assertArrayHasKey(TestLoops::PARTS_BENCHMARK,$result);
        $this->assertArrayHasKey(TestLoops::TEST_NAME,$result[TestLoops::PARTS_BENCHMARK]);
    }
}
