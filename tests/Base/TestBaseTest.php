<?php
/**
 * Created by PhpStorm.
 * User: webguru
 * Date: 26.08.18
 * Time: 16:32
 */

namespace Base;

use TestBase\TestBase;

require_once __DIR__ . '/../../Output/Output.php';
require_once __DIR__ . '/../../Benchmark/TestBase.php';

class TestBaseTest extends \PHPUnit_Framework_TestCase
{
    /**
     *  Test config file exists
     */
    public function testConfigFileExists()
    {
        $this->assertFileExists(__DIR__ . '/../../config.inc.php');
    }

    /**
     * @depends testConfigFileExists
     */
    public function testCountValues()
    {
        $this->assertLessThan(100001,COUNT_MATH);
        $this->assertLessThan(100001,COUNT_ARRAYS);
        $this->assertLessThan(1000001,COUNT_DB);
        $this->assertLessThan(10000001,COUNT_IFELSE);
        $this->assertLessThan(10000001,COUNT_LOOPS);
        $this->assertLessThan(100001,COUNT_STRING);
    }
}
