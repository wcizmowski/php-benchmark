<?php

namespace Tests;

require_once 'TestBase.php';
require_once 'TestMath.php';
require_once 'TestLoops.php';
require_once 'TestIfElse.php';
require_once 'TestString.php';
require_once 'TestArrays.php';
require_once 'TestDB.php';
require_once __DIR__ . '/../Output.php';

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

    private $opt;

    private $testDB;

    public function __construct($count = 9999)
    {
        parent::__construct($count);

        $this->opt = getopt('',['db', 'help']);

        $this->count = $count;
        $this->testMath = new TestMath();
        $this->testLoops = new TestLoops();
        $this->testIfElse = new TestIfElse();
        $this->testString = new TestString();
        $this->testArrays = new TestArrays();

        if (isset($this->opt['db'])) {
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
    public function RunTest()
    {
        $this->timeStart = microtime(true);

        $this->testMath->Test($this->result, 100000);
        $this->testLoops->Test($this->result, 1000000);
        $this->testIfElse->Test($this->result, 10000000);
        $this->testString->Test($this->result, 100000);
        $this->testArrays->Test($this->result,1000000);

        if (isset($this->opt['db'])) {
            $this->testDB->Test($this->result);
        }


        $this->result['total'] = $this->timer_diff($this->timeStart);
    }

    /**
     * Display tests results
     */
    public function DisplayResults()
    {
        Output::DisplayResults($this->result);
    }

}
