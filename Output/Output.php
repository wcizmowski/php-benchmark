<?php

namespace Output;

require_once __DIR__ . '/../config.inc.php';
require_once 'PhpAnsiColor.php';
require_once __DIR__ . '/../Tests/TestBase.php';

use Phalcon\Config\Adapter\Php;
use PhpAnsiColor\PhpAnsiColor;
use TestBase\TestBase;

final class Output
{
    const PARTS = [
        TestBase::PARTS_SYSINFO,
        TestBase::PARTS_BENCHMARK,
        TestBase::PARTS_MYSQL,
        TestBase::PARTS_TOTAL,
    ];

    /**
     * @param $array
     * @return string
     */
    public static function ArrayToText($array)
    {
        $result = '';
        $totalTime = false;

        if (\is_array($array)) {
            $result .= PHP_EOL;
            foreach ($array as $k => $v) {
                if (\in_array(htmlentities($k), self::PARTS, true)) {
                    if (htmlentities($k) !== TestBase::PARTS_TOTAL) {
                        $result .= '' . PhpAnsiColor::set(htmlentities($k), 'green') . ':';
                    } else {
                        $result .= '' . PhpAnsiColor::set(htmlentities($k), 'green+bold') . ':';
                        $totalTime = true;
                    }
                } else {
                    $result .= '' . htmlentities($k) . ' = ';
                }
                if (!\is_array($v) && strpos($v, '.')) {
                    if (!$totalTime) {
                        $result .= PhpAnsiColor::set(self::ArrayToText($v), 'yellow');
                    } else {
                        $result .= PhpAnsiColor::set(self::ArrayToText($v), 'yellow+bold');
                    }
                } else {
                    $result .= self::ArrayToText($v);
                }
                $result .= PHP_EOL;
            }
        } else {
            $result = htmlentities($array);
        }

        return $result;
    }

    /**
     * @param $array
     * @return string
     */
    public static function ArrayToHTML($array)
    {
        $result = '';
        if (\is_array($array)) {
            $result .= '<table align="center">';
            foreach ($array as $k => $v) {
                $result .= '<tr><td>';
                $result .= '<strong>' . htmlentities($k) . '</strong></td><td>';
                $result .= self::ArrayToHTML($v);
                $result .= '</td></tr>';
            }
            $result .= '</table>';
        } else {
            $result = htmlentities($array);
        }
        return $result;
    }

    /**
     *  Display header of HTML page
     * @param $text
     * @return mixed
     */
    private static function DisplayHTML($text)
    {
        $content = file_get_contents(__DIR__ . '/output.html');
        return str_replace('[content]',$text,$content);
    }

    /**
     * Display tests results
     * @param $text
     */
    public static function DisplayProgress($text)
    {
        if (self::isCommandLineMode()) {
            echo 'Test ';
            PhpAnsiColor::log($text,'yellow');
            echo ' ...' . PHP_EOL;
        }
    }

    /**
     * Display tests results
     * @param $text
     */
    public static function DisplayProgressInside($text)
    {
        if (self::isCommandLineMode()) {
            echo ' | ';
            PhpAnsiColor::log($text,'yellow');
            echo PHP_EOL;
        }
    }

    /**
     * Display app info
     *
     */
    public static function DisplayHelp()
    {
        $content = file_get_contents(__DIR__ . '/help.txt');
        $text = PhpAnsiColor::replace($content,'\[.*?\]','yellow');
        echo $text;
    }

    /**
     * Display tests results
     * @param $array
     */
    public static function DisplayResults($array)
    {
        if (self::isCommandLineMode()) {

            PhpAnsiColor::log('-------- Results begin --------', 'green+bold');

            echo self::ArrayToText($array);

            PhpAnsiColor::log('-------- Results End --------', 'green+bold');
            echo PHP_EOL;
            echo PHP_EOL;

        } else {
            echo self::DisplayHTML(self::ArrayToHTML($array));
        }
    }

    /**
     * Check if Command line mode
     *
     * @return bool
     */
    public static function isCommandLineMode()
    {
        return \defined('STDIN') ||
            (empty($_SERVER['REMOTE_ADDR']) && !isset($_SERVER['HTTP_USER_AGENT']) && \count($_SERVER['argv']) > 0);
    }
}