<?php
/**
 * Created by PhpStorm.
 * User: witek
 * Date: 14.08.18
 * Time: 13:35
 */

namespace TestLoops;

require_once 'TestBase.php';
require_once __DIR__ . '/../Output.php';

use TestBase\TestBase;
use Output\Output;

class TestLoops extends TestBase
{

    const TEST_NAME = 'loops';

    /**
     * @param $result
     * @param int $count
     */
    public function Test(&$result, $count = 999999)
    {
        Output::DisplayProgress(self::TEST_NAME);

        $timeStart = microtime(true);

        $j = 0;
        for ($i = 0; $i < $count; ++$i) {
            ++$j;
        }
        $i = 0;
        while ($i < $count) {
            ++$i;
        }

        $result['benchmark'][self::TEST_NAME] = $this->timer_diff($timeStart);
    }
}
