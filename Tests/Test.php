<?php

namespace Tests;

require_once 'TestBase.php';
require_once 'TestMath.php';
require_once 'TestLoops.php';
require_once 'TestIfElse.php';
require_once 'TestString.php';
require_once __DIR__ . '/../Output.php';

use TestBase\TestBase;
use TestMath\TestMath;
use TestLoops\TestLoops;
use TestIfElse\TestIfElse;
use TestString\TestString;
use Output\Output;

class Test extends TestBase
{

    private $testMath;

    private $testLoops;

    private $testIfElse;

    public function __construct($count = 9999)
    {
        parent::__construct($count);

        $this->count = $count;
        $this->testMath = new TestMath();
        $this->testLoops = new TestLoops();
        $this->testIfElse = new TestIfElse();
        $this->testString = new TestString();
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
