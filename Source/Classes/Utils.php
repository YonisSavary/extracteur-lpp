<?php 

namespace Source\Classes;

use ZipArchive;

class Utils
{
    const TARGET = "http://www.codage.ext.cnamts.fr/f_mediam/fo/tips/LPPTOT702.zip";

    public static function explore(string $directory)
    {
        $files = [];
        foreach (array_slice(scandir($directory), 2) as $file)
        {
            $file = $directory . "/" . $file;
            if (is_file($file))
                $files[] = $file;
            else 
                array_push($files, ...self::explore($file));
        }
        return $files;
    }


    public static function strToDecimal(string $value, int $decimal=2)
    {
        $value = trim($value);
        return substr($value, 0, -$decimal). "." . substr($value, -$decimal);
    }
    

    public static function convertPrice(string $value)
    {
        return self::strToDecimal($value, 2);
    }


    public static function convertMajoration(string $value)
    {
        return self::strToDecimal($value, 3);
    }


    public static function convertBool(string $value)
    {
        $value = strtoupper($value);
        if ($value === "O" || $value == "1")
            return "true";
        return "false";
    }


    public static function convertDate(string $value)
    {
        list($y, $yy, $m, $d) = str_split($value, 2);
        $date = "$y$yy-$m-$d";
        return ($date == "0000-00-00")? null: $date;
    }



    public static function ensureSourceFile()
    {
        $targetInfo = pathinfo(self::TARGET);
        $filename = $targetInfo["filename"];
        $archive = $targetInfo["basename"];

        $sourceFile = "./tmp/$filename";

        if (!is_file($sourceFile))
        {
            echo "Downloading File...";
            copy(self::TARGET, "./tmp/$archive");

            if (!is_file("./tmp/$archive"))
                die ("Cannot download file [".self::TARGET."] !");
            
            echo "Done\n";

            $zip = new ZipArchive();
            $zip->open("./tmp/$archive");
            $zip->extractTo("./tmp/");
            $zip->close();
            unlink("./tmp/$archive");
        }

        if (!is_file("./tmp/$filename"))
            die ("Cannot download and/or extract [".self::TARGET."]");

        return $sourceFile;
    }
}