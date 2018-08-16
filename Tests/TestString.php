<?php
/**
 * Created by PhpStorm.
 * User: witek
 * Date: 14.08.18
 * Time: 13:40
 */

namespace TestString;

require_once 'TestBase.php';
require_once __DIR__ . '/../Output.php';

use TestBase\TestBase;
use Output\Output;

class TestString extends TestBase
{

    const TEST_NAME = 'string';

    /**
     * @param $result
     * @param int $count
     */
    public function Test(&$result, $count = 99999)
    {
        Output::DisplayProgress(self::TEST_NAME);

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

        $result['benchmark'][self::TEST_NAME] = $this->timer_diff($timeStart);
    }
}
