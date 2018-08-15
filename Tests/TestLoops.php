<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: witek
 * Date: 14.08.18
 * Time: 13:35
 */

namespace TestLoops;

require_once 'TestBase.php';

use TestBase\TestBase;

class TestLoops extends TestBase
{

    /**
     * @param $result
     * @param int $count
     */
    public function Test(&$result, $count = 999999)
    {
        $timeStart = microtime(true);

        $j = 0;
        for ($i = 0; $i < $count; ++$i) {
            ++$j;
        }
        $i = 0;
        while ($i < $count) {
            ++$i;
        }

        $result['benchmark']['loops'] = $this->timer_diff($timeStart);
    }
}
