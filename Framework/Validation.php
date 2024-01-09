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

    public static function validateNumber($value, $min = 0, $max = INF)
    {
        if (!is_numeric($value)) {
            return false;
        }
        return $value >= $min && $value <= $max;
    }

    public static function validatePhoneNumber($value)
    {
        $value = trim($value);
        $value = str_replace(' ', '', $value);
        if (str_starts_with($value, '+')) {
            $value = substr($value, 1);
        }
        if (str_contains($value, '-')) {
            $value = str_replace('-', '', $value);
        }
        if (!is_numeric($value)) {
            return false;
        }
        //TODO: better regex can be written for universal phone number validation
        return true;
    }
}
