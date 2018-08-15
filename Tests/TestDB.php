<?php
/**
 * Created by PhpStorm.
 * User: witek
 * Date: 14.08.18
 * Time: 13:42
 */

namespace TestDB;

require_once 'TestBase.php';

use TestBase\TestBase;

class TestDB extends TestBase
{

    private $options = [];

    private $connected;

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


    public function Test(&$result)
    {
        $timeStart = microtime(true);

        try {
            error_reporting(0);
            $link = mysqli_connect($this->options['db.host'], $this->options['db.user'], $this->options['db.pw']);
            error_reporting(1);
            if ($link) {
                $this->connected = true ;
                $result['benchmark']['mysql']['connect'] = $this->timer_diff($timeStart);

                mysqli_select_db($link, $this->options['db.name']);
                $result['benchmark']['mysql']['select_db'] = $this->timer_diff($timeStart);

                $dbResult = mysqli_query($link, 'SELECT VERSION() as version;');
                $arr_row = mysqli_fetch_array($dbResult);
                $result['sysinfo']['mysql_version'] = $arr_row['version'];
                $result['benchmark']['mysql']['query_version'] = $this->timer_diff($timeStart);

                $query = "SELECT BENCHMARK(1000000,ENCODE('hello',RAND()));";
                $dbResult = mysqli_query($link, $query);
                $result['benchmark']['mysql']['query_benchmark'] = $this->timer_diff($timeStart);

                mysqli_close($link);

                $result['benchmark']['mysql']['total'] = $this->timer_diff($timeStart);
            }
        }
        catch (\Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
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