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

require_once __DIR__ . '/Tests/Test.php';
require_once 'Output.php';

use Tests\Test;
use Output\Output;


$opt = getopt('', ['db', 'help']);

if (Output::isCommandLineMode() && (isset($opt['help']) || (!file_exists('config.inc.php')))) {
    Output::DisplayHelp();
} else {
    $test = new Test(isset($opt['db']) || isset($_GET['db']));
    $test->RunTest();
    $test->DisplayResults();
}
