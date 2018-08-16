<?php
/**
 * Created by PhpStorm.
 * User: witek
 * Date: 14.08.18
 * Time: 13:42
 */

namespace TestDB;

require_once 'TestBase.php';
require_once __DIR__ . '/../Output.php';

use TestBase\TestBase;
use Output\Output;

class TestDB extends TestBase
{

    const TEST_NAME = 'mysql';

    private $options = [];

    private $connected = false;

    /**
     * Init DB
     * @param string $host
     * @param string $user
     * @param string $password
     * @param string $name
     */
    public function InitDB(
        $host = '127.0.0.1',
        $user = 'test',
        $password = 'mIf#pxWsR1r08lck',
        $name = 'test'
    )
    {
        // Optional: mysql performance test
        $this->options['db.host'] = $host;
        $this->options['db.user'] = $user;
        $this->options['db.pw'] = $password;
        $this->options['db.name'] = $name;
    }


    /**
     * @param $result
     * @return mixed
     */
    public function Test(&$result)
    {
        Output::DisplayProgress(self::TEST_NAME);

        $timeStart = microtime(true);

        $link = mysqli_connect($this->options['db.host'], $this->options['db.user'], $this->options['db.pw']);

        if ($link) {
            $this->connected = true;
            $result['benchmark'][self::TEST_NAME]['connect'] = $this->timer_diff($timeStart);

            mysqli_select_db($link, $this->options['db.name']);
            $result['benchmark'][self::TEST_NAME]['select_db'] = $this->timer_diff($timeStart);

            $dbResult = mysqli_query($link, 'SELECT VERSION() as version;');
            $arr_row = mysqli_fetch_array($dbResult);
            $result['sysinfo']['mysql_version'] = $arr_row['version'];
            $result['benchmark'][self::TEST_NAME]['query_version'] = $this->timer_diff($timeStart);

            $query = "SELECT BENCHMARK(1000000,ENCODE('hello',RAND()));";
            $dbResult = mysqli_query($link, $query);
            $result['benchmark'][self::TEST_NAME]['query_benchmark'] = $this->timer_diff($timeStart);

            mysqli_close($link);

            $result['benchmark'][self::TEST_NAME]['total'] = $this->timer_diff($timeStart);
        }

        return $result;
    }

    /**
     * @return mixed
     */
    public function getConnected()
    {
        return $this->connected;
    }
}