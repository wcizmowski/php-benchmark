<?php
/**
 * Created by PhpStorm.
 * User: witek
 * Date: 14.08.18
 * Time: 13:34
 */

namespace Tests;

class Test
{

    private $count;

    public function __construct($count = 9999)
    {
        $this->count = $count;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    public function RunTest()
    {
        //TODO
    }

    public function Results()
    {
        echo 'test' . PHP_EOL;
    }
}
