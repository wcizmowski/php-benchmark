<?php

/**
 * Created by PhpStorm.
 * User: witek
 * Date: 14.08.18
 * Time: 13:23
 */

require_once __DIR__ . '/Tests/Test.php';

$test = new \Tests\Test();

$test->RunTest();
$test->DisplayResults();
