<?php
/**
 * Created by PhpStorm.
 * User: witek
 * Date: 16.08.18
 * Time: 10:30
 */

namespace TestsArrays;

require_once 'TestBase.php';

require_once __DIR__ . '/../Output.php';

use TestBase\TestBase;
use Output\Output;

class TestArrays extends TestBase
{

    const TEST_NAME = 'arrays';

    /**
     * @param $result
     * @param $count
     */
    public function Test(&$result, $count = 99999)
    {
        Output::DisplayProgress(self::TEST_NAME);

        $timeStart = microtime(true);

        for ($i = 0; $i < $count; $i++) {
            $a[] = $i;
        }
        unset($a);

        for ($i = 0; $i < $count; $i++) {
            $a['test' . $i] = $i;
        }

        $result['benchmark'][self::TEST_NAME] = $this->timer_diff($timeStart);
    }
}