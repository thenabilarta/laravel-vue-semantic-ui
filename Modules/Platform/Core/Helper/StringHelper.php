<?php

namespace Modules\Platform\Core\Helper;

/**
 * Class StringHelper
 * @package Modules\Platform\Core\Helper
 */
class StringHelper
{

    /**
     * @param $string
     * @param $char
     * @return bool|string
     */
    public static function fromLastChar($string, $char)
    {
        return substr(strrchr($string, $char), 1);
    }

    public static function validationArrayToString($array)
    {
        $output = implode(', ', array_map(
            function ($v, $k) { return sprintf(" %s '%s' dependent records found. ", $k, $v); },
            $array,
            array_keys($array)
        ));
        return $output;
    }
}
