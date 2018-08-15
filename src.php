<?php

/**
 * PHP Script to benchmark PHP and MySQL-Server
 *
 * inspired by / thanks to:
 * - www.php-benchmark-script.com  (Alessandro Torrisi)
 * - www.webdesign-informatik.de
 *
 * @author odan
 * @license MIT
 */
// -----------------------------------------------------------------------------
// Setup
// -----------------------------------------------------------------------------
set_time_limit(120); // 2 minutes

$options = [];

// Optional: mysql performance test
//$options['db.host'] = '127.0.0.1';
//$options['db.user'] = 'root';
//$options['db.pw'] = 'mIf#pxWsR1r08lck';
//$options['db.name'] = 'test';

// -----------------------------------------------------------------------------
// Main
// -----------------------------------------------------------------------------
// check performance
$benchmarkResult = test_benchmark($options);

// html output
/*echo "<!DOCTYPE html>\n<html><head>\n";
echo '<style>
    table {
        color: #333; 
        font-family: Helvetica, Arial, sans-serif;
        width: 640px;
        border-collapse:
        collapse; border-spacing: 0;
    }

    td, th {
        border: 1px solid #CCC; height: 30px;
    } 

    th {
        background: #F3F3F3;
        font-weight: bold; 
    }

    td {
        background: #FAFAFA; 
    }
    </style>
    </head>
    <body>';*/

echo array_to_text($benchmarkResult);

//echo '</body></html>';

exit;

// -----------------------------------------------------------------------------
// Benchmark functions
// -----------------------------------------------------------------------------

function test_benchmark($settings)
{
    $timeStart = microtime(true);

    $result = [];
    $result['version'] = '1.0';
    $result['sysinfo']['time'] = date('Y-m-d H:i:s');
    $result['sysinfo']['php_version'] = PHP_VERSION;
    $result['sysinfo']['platform'] = PHP_OS;

    test_math($result);
    test_string($result);
    test_loops($result);
    test_ifelse($result);
    if (isset($settings['db.host'])) {
        test_mysql($result, $settings);
    }

    $result['total'] = timer_diff($timeStart);
    return $result;
}

function test_math(&$result, $count = 99999)
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

function test_string(&$result, $count = 99999)
{
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
    $result['benchmark']['string'] = timer_diff($timeStart);
}

function test_loops(&$result, $count = 999999)
{
    $timeStart = microtime(true);
    $j = 0;
    for ($i = 0; $i < $count; ++$i) {
        ++$j;
    }
    $i = 0;
    while ($i < $count) {
        ++$i;
    }
    $result['benchmark']['loops'] = timer_diff($timeStart);
}

function test_ifelse(&$result, $count = 999999)
{
    $timeStart = microtime(true);
    $j = 0;
    for ($i = 0; $i < $count; $i++) {
        if ($i === -1) {
            ++$j;
        } elseif ($i === -2) {
            ++$j;
        } else if ($i === -3) {
            ++$j;
        }
    }
    $result['benchmark']['ifelse'] = timer_diff($timeStart);
}

function test_mysql(&$result, $settings)
{
    $timeStart = microtime(true);

    $link = mysqli_connect($settings['db.host'], $settings['db.user'], $settings['db.pw']);
    $result['benchmark']['mysql']['connect'] = timer_diff($timeStart);

    //$arr_return['sysinfo']['mysql_version'] = '';

    mysqli_select_db($link, $settings['db.name']);
    $result['benchmark']['mysql']['select_db'] = timer_diff($timeStart);

    $dbResult = mysqli_query($link, 'SELECT VERSION() as version;');
    $arr_row = mysqli_fetch_array($dbResult);
    $result['sysinfo']['mysql_version'] = $arr_row['version'];
    $result['benchmark']['mysql']['query_version'] = timer_diff($timeStart);

    $query = "SELECT BENCHMARK(1000000,ENCODE('hello',RAND()));";
    $dbResult = mysqli_query($link, $query);
    $result['benchmark']['mysql']['query_benchmark'] = timer_diff($timeStart);

    mysqli_close($link);

    $result['benchmark']['mysql']['total'] = timer_diff($timeStart);
    return $result;
}

function timer_diff($timeStart)
{
    return number_format(microtime(true) - $timeStart, 3);
}

function array_to_html($array)
{
    $result = '';
    if (is_array($array)) {
        $result .= '<table>';
        foreach ($array as $k => $v) {
            $result .= '<tr><td>';
            $result .= '<strong>' . htmlentities($k) . '</strong></td><td>';
            $result .= array_to_html($v);
            $result .= '</td></tr>';
        }
        $result .= '\n</table>';
    } else {
        $result = htmlentities($array);
    }
    return $result;
}

function array_to_text($array)
{
    $result = '';
    if (is_array($array)) {
        $result .= PHP_EOL;
        foreach ($array as $k => $v) {
            $result .= '' . htmlentities($k) . '=';
            $result .= array_to_text($v);
            $result .= PHP_EOL;
        }
    } else {
        $result = htmlentities($array);
    }
    return $result;
}
