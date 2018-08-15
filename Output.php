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

final class Output
{
    private static $ANSI_CODES = array(
        'off' => 0,
        'bold' => 1,
        'italic' => 3,
        'underline' => 4,
        'blink' => 5,
        'inverse' => 7,
        'hidden' => 8,
        'black' => 30,
        'red' => 31,
        'green' => 32,
        'yellow' => 33,
        'blue' => 34,
        'magenta' => 35,
        'cyan' => 36,
        'white' => 37,
        'black_bg' => 40,
        'red_bg' => 41,
        'green_bg' => 42,
        'yellow_bg' => 43,
        'blue_bg' => 44,
        'magenta_bg' => 45,
        'cyan_bg' => 46,
        'white_bg' => 47
    );


    const PARTS = ['benchmark', 'sysinfo'];


    public static function set($str, $color)
    {
        $color_attrs = explode('+', $color);
        $ansi_str = '';
        foreach ($color_attrs as $attr) {
            $ansi_str .= "\033[" . self::$ANSI_CODES[$attr] . 'm';
        }
        $ansi_str .= $str . "\033[" . self::$ANSI_CODES['off'] . 'm';

        return $ansi_str;
    }

    public static function log($message, $color)
    {
        /** @noinspection ForgottenDebugOutputInspection */
        error_log(self::set($message, $color));
    }


    public static function replace($full_text, $search_regexp, $color)
    {
        $new_text = preg_replace_callback(
            "/($search_regexp)/",
            function ($matches) use ($color) {
                return self::set($matches[1], $color);
            },
            $full_text
        );

        return $new_text === true ? $new_text : $full_text;
    }

    /**
     * @param $array
     * @return string
     */
    public static function ArrayToText($array): string
    {
        $result = '';

        if (\is_array($array)) {
            $result .= PHP_EOL;
            foreach ($array as $k => $v) {
                if (\in_array(htmlentities($k), self::PARTS, true)) {
                    $result .= '' . htmlentities($k) . ':';
                } else {
                    $result .= '' . htmlentities($k) . ' = ';
                }
                if (strpos($v,'.')) {
                    $result .= self::set(self::ArrayToText($v), 'blue');
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
    public static function ArrayToHTML($array): string
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
     * Display tests results
     * @param $array
     */
    public static function DisplayResults($array): void
    {
        if (self::is_cli()) {
            echo self::ArrayToText($array);
            /** @noinspection ForgottenDebugOutputInspection */
            error_log(self::set('Finished', 'green+bold') . ' all tests.' . PHP_EOL);
        }
        else {
            echo self::ArrayToHTML($array);
        }
    }

    /**
     * @return bool
     */
    private static function is_cli(): bool
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