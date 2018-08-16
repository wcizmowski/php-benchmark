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

require_once 'PhpAnsiColor.php';
require_once  __DIR__ . '/Tests/TestBase.php';

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
        $totalTime = false ;

        if (\is_array($array)) {
            $result .= PHP_EOL;
            foreach ($array as $k => $v) {
                if (\in_array(htmlentities($k), self::PARTS, true)) {
                    if (htmlentities($k)!==TestBase::PARTS_TOTAL) {
                        $result .= '' . PhpAnsiColor::set(htmlentities($k), 'green') . ':';
                    }
                    else {
                        $result .= '' . PhpAnsiColor::set(htmlentities($k), 'green+bold') . ':';
                        $totalTime = true ;
                    }
                } else {
                    $result .= '' . htmlentities($k) . ' = ';
                }
                if (!\is_array($v) && strpos($v,'.')) {
                    if (!$totalTime) {
                        $result .= PhpAnsiColor::set(self::ArrayToText($v), 'yellow');
                    }
                    else {
                        $result .= PhpAnsiColor::set(self::ArrayToText($v), 'yellow+bold');
                    }
                }
                else {
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
            $result .= '<table>';
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
     */
    private static function DisplayHTMLHeader()
    {
        echo '<!DOCTYPE html>
                <html>
                <head>
                    <style>
                        table {
                            color: #333; 
                            font-family: Helvetica, Arial, sans-serif;
                            width: 800px;
                            border-collapse:
                            collapse; border-spacing: 8;
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
                        tr:nth-of-type(odd) {
                            background-color: rgba(149,149,149,0.28);
                        }   
                        </style>
                </head>
            <body>';
    }

    private static function DisplayHTMLFooter()
    {
        echo '</body></html>';
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
            error_log( ' | ' . PhpAnsiColor::set($text, 'yellow'));
        }
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
        }
        else {
            self::DisplayHTMLHeader();
            echo self::ArrayToHTML($array);
            self::DisplayHTMLFooter();
        }
    }

    /**
     * @return bool
     */
    private static function isCommandLineMode()
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