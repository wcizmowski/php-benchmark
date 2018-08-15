<?php
/**
 * Created by PhpStorm.
 * User: witek
 * Date: 14.08.18
 * Time: 13:42
 */

namespace TestIfElse;

require_once 'TestBase.php';

use TestBase\TestBase;

class TestIfElse extends TestBase
{

    /**
     * @param $result
     * @param int $count
     */
    public function Test(&$result, $count = 999999): void
    {
        $timeStart = microtime(true);
        $j = 0;
        for ($i = 0; $i < $count; $i++) {
            if ($i === -1) {
                ++$j;
            } elseif ($i === -2) {
                ++$j;
            } else if ($i === -3) {
                ++$j;
            }
        }
        $result['benchmark']['ifelse'] = $this->timer_diff($timeStart);
    }
}