<?php
/**
 * Created by PhpStorm.
 * User: witek
 * Date: 14.08.18
 * Time: 13:53
 */

namespace Output;

final class Output
{

    /**
     * @param $array
     * @return string
     */
    public static function array_to_text($array): string
    {
        $result = '';
        if (\is_array($array)) {
            $result .= PHP_EOL;
            foreach ($array as $k => $v) {
                $result .= '' . htmlentities($k) . '=';
                $result .= self::array_to_text($v);
                $result .= PHP_EOL;
            }
        } else {
            $result = htmlentities($array);
        }
        return $result;
    }
}