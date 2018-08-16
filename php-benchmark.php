<?php

/**
 * Created by PhpStorm.
 * User: witek
 * Date: 14.08.18
 * Time: 13:23
 */

require_once __DIR__ . '/Tests/Test.php';
require_once 'Output.php';

use Tests\Test;
use Output\Output;

$opt = getopt('',['db', 'help']);

$test = new Test(isset($opt['db']) || isset($_GET['db']));

if (isset($opt['help']) && Output::isCommandLineMode()) {
    Output::DisplayHelp();
}
else {
    $test->RunTest();
    $test->DisplayResults();
}
