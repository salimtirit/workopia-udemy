<?php

namespace Framework;

class Validation
{
    public static function validateString($value, $min = 1, $max = INF)
    {
        if (!is_string($value)) {
            return false;
        }
        $length = strlen(trim($value));
        return $length >= $min && $length <= $max;
    }

    public static function validateEmail($value)
    {
        return filter_var(trim($value), FILTER_VALIDATE_EMAIL);
    }

    public static function validateMatch($value, $match)
    {
        return trim($value) === trim($match);
    }
}
