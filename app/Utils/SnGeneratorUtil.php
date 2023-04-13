<?php

namespace App\Utils;

class SnGeneratorUtil
{
    public static function generate()
    {
        $prefix = "SN";
        $min = 1000000;
        $max = 9999999;

        return $prefix . rand($min, $max);
    }
}
