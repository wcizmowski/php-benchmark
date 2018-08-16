<?php
/**
 * php-ansi-color
 *
 * Original
 *     https://github.com/loopj/commonjs-ansi-color
 *
 * @code
 * <?php
 * require_once "ansi-color.php";
 *
 * use PhpAnsiColor\Color;
 *
 * // Print the word "Error" to stdout in red
 * error_log(Color::set("Error", "red"));
 *
 * // Print the word "Error" in red and underlined
 * error_log(Color::set("Error", "red+underline"));
 *
 * // Print the word "Success" in bold green, followed by a message
 * error_log(Color::set("Success", "green+bold"), "Something was successful!");
 * @endcode
 */

namespace Output;

require_once 'config.inc.php';
require_once 'PhpAnsiColor.php';
require_once __DIR__ . '/Tests/TestBase.php';

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
        $content = file_get_contents('output.html');
        return str_replace('[content]',$text,$content);
    }

    /**
     * Display tests results
     * @param $text
     */
    public static function DisplayProgress($text)
    {
        if (self::isCommandLineMode()) {
            /** @noinspection ForgottenDebugOutputInspection */
            error_log('Test ' . PhpAnsiColor::set($text, 'yellow') . ' ...');
        }
    }

    /**
     * Display tests results
     * @param $text
     */
    public static function DisplayProgressInside($text)
    {
        if (self::isCommandLineMode()) {
            /** @noinspection ForgottenDebugOutputInspection */
            error_log(' | ' . PhpAnsiColor::set($text, 'yellow'));
        }
    }

    /**
     * Display app info
     *
     */
    public static function DisplayHelp()
    {
        /** @noinspection ForgottenDebugOutputInspection */
        error_log(PhpAnsiColor::set(INFO1, 'white'));
        /** @noinspection ForgottenDebugOutputInspection */
        error_log(PhpAnsiColor::set(INFO2, 'yellow'));
        /** @noinspection ForgottenDebugOutputInspection */
        error_log(PhpAnsiColor::set(INFO3, 'white'));
        /** @noinspection ForgottenDebugOutputInspection */
        error_log(PhpAnsiColor::set(INFO4, 'white'));
    }

    /**
     * Display tests results
     * @param $array
     */
    public static function DisplayResults($array)
    {
        if (self::isCommandLineMode()) {
            /** @noinspection ForgottenDebugOutputInspection */
            error_log(PhpAnsiColor::set('-------- Results begin --------', 'green+bold'));
            echo self::ArrayToText($array);
            /** @noinspection ForgottenDebugOutputInspection */
            error_log(PHP_EOL . PhpAnsiColor::set('-------- Results End --------', 'green+bold') . PHP_EOL);
        } else {
            echo self::DisplayHTML(self::ArrayToHTML($array));
        }
    }

    /**
     * @return bool
     */
    public static function isCommandLineMode()
    {
        if (\defined('STDIN')) {
            return true;
        }

        if (empty($_SERVER['REMOTE_ADDR']) && !isset($_SERVER['HTTP_USER_AGENT']) && \count($_SERVER['argv']) > 0) {
            return true;
        }

        return false;
    }
}