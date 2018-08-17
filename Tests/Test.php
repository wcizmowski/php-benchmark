<?php

namespace Tests;

require_once __DIR__ . '/../config.inc.php';
require_once 'TestBase.php';
require_once 'TestMath.php';
require_once 'TestLoops.php';
require_once 'TestIfElse.php';
require_once 'TestString.php';
require_once 'TestArrays.php';
require_once 'TestDB.php';
require_once __DIR__ . '/../Output/Output.php';

use TestBase\TestBase;
use TestMath\TestMath;
use TestLoops\TestLoops;
use TestIfElse\TestIfElse;
use TestString\TestString;
use TestsArrays\TestArrays;
use TestDB\TestDB;
use Output\Output;

class Test extends TestBase
{

    private $testMath;

    private $testLoops;

    private $testIfElse;

    private $testString;

    private $testArrays;

    private $testDB;

    public function __construct($dbTest, $count = 9999)
    {
        parent::__construct($count);

        $this->count = $count;
        $this->testMath = new TestMath();
        $this->testLoops = new TestLoops();
        $this->testIfElse = new TestIfElse();
        $this->testString = new TestString();
        $this->testArrays = new TestArrays();

        if ($dbTest) {
            $this->testDB = new TestDB();
            $this->testDB->InitDB();
        }
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     *  Run all test
     */
    public function Test()
    {
        $this->timeStart = microtime(true);

        $this->testMath->Test($this->result, COUNT_MATH);
        $this->testLoops->Test($this->result, COUNT_LOOPS);
        $this->testIfElse->Test($this->result, COUNT_IFELSE);
        $this->testString->Test($this->result, COUNT_STRING);
        $this->testArrays->Test($this->result, COUNT_ARRAYS);

        if ($this->testDB !== null) {
            $this->testDB->Test($this->result);
        }

        $this->result[self::PARTS_TOTAL] = $this->timer_diff($this->timeStart);
    }

    /**
     * Display tests results
     */
    public function DisplayResults()
    {
        Output::DisplayResults($this->result);
    }

}
