<?php
/**
 * Created by PhpStorm.
 * User: witek
 * Date: 14.08.18
 * Time: 13:42
 */

namespace TestIfElse;

require_once 'TestBase.php';
require_once __DIR__ . '/../Output/Output.php';

use TestBase\TestBase;
use Output\Output;

class TestIfElse extends TestBase
{

    const TEST_NAME = 'if else';

    /**
     * @param $result
     * @param int $count
     */
    public function Test(&$result, $count = 999999)
    {
        Output::DisplayProgress(self::TEST_NAME);

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

        $result['benchmark'][self::TEST_NAME] = $this->timer_diff($timeStart);
    }
}