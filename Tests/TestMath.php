<?php

/**
 * Created by PhpStorm.
 * User: witek
 * Date: 14.08.18
 * Time: 13:39
 */

namespace TestMath;

require_once 'TestBase.php';

use TestBase\TestBase;

class TestMath extends TestBase
{

    /**
     * @param $result
     * @param $count
     */
    public function Test(&$result, $count = 99999)
    {
        $timeStart = microtime(true);

        $mathFunctions = ['abs', 'acos', 'asin', 'atan', 'bindec', 'floor', 'exp', 'sin',
            'tan', 'pi', 'is_finite', 'is_nan', 'sqrt'
        ];
        for ($i = 0; $i < $count; $i++) {
            foreach ($mathFunctions as $function) {
                $function($i);
            }
        }

        $result['benchmark']['math'] = $this->timer_diff($timeStart);
    }
}
