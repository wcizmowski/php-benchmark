<?php

/**
 * Created by PhpStorm.
 * User: witek
 * Date: 14.08.18
 * Time: 13:23
 */

if (!file_exists('config.inc.php')) {
    echo
        PHP_EOL .
        'File config.inc.php is missing' . PHP_EOL .
        'Copy it from config.sample.inc.php' . PHP_EOL .
        PHP_EOL;
    exit;
}

require_once __DIR__ . '/Benchmark/Test.php';
require_once __DIR__ . '/Output/Output.php';

use Tests\Test;
use Output\Output;

$opt = getopt('', [OPTION_DB, OPTION_HELP]);

if (isset($opt[OPTION_HELP]) && Output::isCommandLineMode()) {
    Output::DisplayHelp();
} else {
    $test = new Test(isset($opt[OPTION_DB]) || isset($_GET[OPTION_DB]));
    $test->Test();
    $test->DisplayResults();
}
