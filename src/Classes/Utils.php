<?php

namespace YonisSavary\ExtracteurLPP\Classes;

class Utils
{
    public static function strToDecimal(string $value, int $decimal=2): string
    {
        $value = trim($value);
        return substr($value, 0, -$decimal). "." . substr($value, -$decimal);
    }


    public static function convertPrice(string $value): string
    {
        return self::strToDecimal($value, 2);
    }


    public static function convertMajoration(string $value): string
    {
        return self::strToDecimal($value, 3);
    }


    public static function convertBool(string $value): string
    {
        $value = strtoupper($value);

        if ($value === "1" || $value === "Oui")
            return "true";

        return "false";
    }


    /**
     * 20081231 => 2008-12-31
     */
    public static function convertDate(string $value): ?string
    {
        list($y, $yy, $m, $d) = str_split($value, 2);
        $date = "$y$yy-$m-$d";
        return ($date == "0000-00-00")? null: $date;
    }


    public static function printLine(string $line)
    {
        self::print("$line\n");
    }

    public static function print(string $line)
    {
        if (php_sapi_name() === "cli")
            echo "$line";
    }
}