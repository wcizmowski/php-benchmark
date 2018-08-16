<?php
/**
 * Created by PhpStorm.
 * User: witek
 * Date: 16.08.18
 * Time: 15:07
 */

define('COUNT_MATH', 100000);
define('COUNT_ARRAYS', 1000000);
define('COUNT_DB', 1000000);
define('COUNT_IFELSE', 10000000);
define('COUNT_LOOPS', 1000000);
define('COUNT_STRING', 100000);

define('DB_HOST', 'localhost');
define('DB_NAME', 'test');
define('DB_USER', 'test');
define('DB_PASSWORD', 'mIf#pxWsR1r08lck');

define('INFO1',' /**');

define('INFO2',' * PHP Script benchmark (PHP and MySQL-Server)');

define('INFO3', ' *
 * inspired by / thanks to:
 * - www.php-benchmark-script.com  (Alessandro Torrisi)
 * - www.webdesign-informatik.de
 *
 * @author Witold Ciżmowski, Speednet
 * @license MIT
 */
    ');

define('INFO4', ' /*
 * usage:
 * php php-benchmark.php [option]
 * 
 * --db   with Database test
 * --help this help
 */
    ');