<?php

/**
 * Created by PhpStorm.
 * User: witek
 * Date: 14.08.18
 * Time: 13:23
 */

require_once __DIR__ . '/Tests/Test.php';

use Tests\Test;

$test = new Test();

$test->RunTest();
$test->DisplayResults();
