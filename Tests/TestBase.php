<?php
/**
 * Created by PhpStorm.
 * User: witek
 * Date: 14.08.18
 * Time: 15:53
 */

namespace TestBase;

abstract class TestBase
{
    const PARTS_VERSION_INFO = 'PHP benchmark version';
    const PARTS_SYSINFO = 'sysinfo';
    const PARTS_BENCHMARK = 'benchmark';
    const PARTS_MYSQL = 'mysql';
    const PARTS_TOTAL = 'total';

    public $count;

    public $result = [];

    public $timeStart;

    /**
     * TestBase constructor.
     * @param int $count
     */
    public function __construct($count = 9999)
    {
        $this->result[self::PARTS_VERSION_INFO] = '1.0';
        $this->result[self::PARTS_SYSINFO]['time'] = date('Y-m-d H:i:s');
        $this->result[self::PARTS_SYSINFO]['php_version'] = PHP_VERSION;
        $this->result[self::PARTS_SYSINFO]['platform'] = PHP_OS;

        $this->count = $count;

        set_time_limit(120); // seconds
    }

    /**
     * @param $timeStart
     * @return string
     */
    public function timer_diff($timeStart)
    {
        return number_format(microtime(true) - $timeStart, 3);
    }
}