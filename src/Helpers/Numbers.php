<?php

namespace SM\Helpers;

class Numbers
{
    public static function convertArray(array $arr)
    {
        $result = [];
        foreach ($arr as $value) {
            $result[] = self::convertNumbers($value);
        }

        $result = array_map(function ($value) {
            return self::convertNumbers($value);
        }, $arr);

        return $result;
    }

    public static function convertNumbers($num, $sys = "IND")
    {
        $western = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '.'];
        $eastern = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩', ','];

        return $sys == "IND" ?
            str_replace($western, $eastern, $num) :
            str_replace($eastern, $western, $num);
    }
}
