<?php
/**
 * Created by PhpStorm.
 * User: witek
 * Date: 14.08.18
 * Time: 13:39
 */

class TestMath
{

    /**
     * @param $result
     * @param $count
     */
    public function Test(&$result, $count)
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
        $result['benchmark']['math'] = timer_diff($timeStart);
    }
}
