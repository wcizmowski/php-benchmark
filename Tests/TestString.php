<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: witek
 * Date: 14.08.18
 * Time: 13:40
 */

namespace TestString;

require_once 'TestBase.php';

use TestBase\TestBase;

class TestString extends TestBase
{

    /**
     * @param $result
     * @param int $count
     */
    public function Test(&$result, $count = 99999)
    {
        echo 'Test String...' . PHP_EOL;

        $timeStart = microtime(true);

        $stringFunctions = ['addslashes', 'chunk_split', 'metaphone', 'strip_tags', 'md5', 'sha1',
            'strtoupper', 'strtolower', 'strrev', 'strlen', 'soundex', 'ord'
        ];

        $string = 'the quick brown fox jumps over the lazy dog';
        for ($i = 0; $i < $count; $i++) {
            foreach ($stringFunctions as $function) {
                $function($string);
            }
        }

        $result['benchmark']['string'] = $this->timer_diff($timeStart);
    }
}
