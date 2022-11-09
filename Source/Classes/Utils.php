<?php 

namespace Source\Classes;

class Utils
{
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
}