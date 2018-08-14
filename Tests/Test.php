<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: witek
 * Date: 14.08.18
 * Time: 13:34
 */

namespace Tests;

require_once 'TestBase.php';
require_once 'TestMath.php';
require_once 'TestLoops.php';
require_once __DIR__.'/../Output.php';

use TestBase\TestBase;
use TestMath\TestMath;
use TestLoops\TestLoops;
use Output\Output;

class Test extends TestBase
{

    private $testMath;

    private $testLoops;

    public function __construct($count = 9999)
    {
        parent::__construct($count);

        $this->count = $count;
        $this->testMath = new TestMath();
        $this->testLoops = new TestLoops();
    }

    /**
     * @return int
     */
    public function getCount(): int
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

        $this->testMath->Test($this->result,100000);
        $this->testLoops->Test($this->result,1000000);

        $this->result['total'] = $this->timer_diff($this->timeStart);
    }

    public function DisplayResults()
    {
        echo Output::array_to_text($this->result);
    }

}
