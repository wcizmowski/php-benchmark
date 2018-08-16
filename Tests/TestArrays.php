<?php
/**
 * Created by PhpStorm.
 * User: witek
 * Date: 16.08.18
 * Time: 10:30
 */

namespace TestsArrays;

require_once 'TestBase.php';

use TestBase\TestBase;

class TestArrays extends TestBase
{

    /**
     * @param $result
     * @param $count
     */
    public function Test(&$result, $count = 99999)
    {
        $timeStart = microtime(true);

        for ($i=0; $i<$count; $i++) {
            $a[] = $i;
        }

        $result['benchmark']['arrays'] = $this->timer_diff($timeStart);
    }
}