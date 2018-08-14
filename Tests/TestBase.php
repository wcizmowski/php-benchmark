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
    public $count;

    public $result = [];

    public $timeStart;

    /**
     * TestBase constructor.
     * @param int $count
     */
    public function __construct($count = 9999)
    {
        $this->result['version'] = '1.0';
        $this->result['sysinfo']['time'] = date('Y-m-d H:i:s');
        $this->result['sysinfo']['php_version'] = PHP_VERSION;
        $this->result['sysinfo']['platform'] = PHP_OS;

        $this->count = $count;
    }

    /**
     * @param $timeStart
     * @return string
     */
    public function timer_diff($timeStart): string
    {
        return number_format(microtime(true) - $timeStart, 3);
    }
}