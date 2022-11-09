<?php 

namespace Source\Types;

use Source\Classes\LineSplitter;
use Source\Classes\CustomizedDriver;
use Source\Interfaces\DriverInterface;

class FileEnd implements DriverInterface
{
    use CustomizedDriver;

    public static function getRegex(): string 
    {
        return "/^19901/";
    }

    public static function getSplitter(): LineSplitter
    {
        return (new LineSplitter())
        ->with("Type", 3)
        ->with("NOEMIE", 49)
        ->with("NombreTotal", 8)
        ->with("NombreCodes", 6)
        ->with("Sceau", 10)
        ->with("Inutilise", 52)
        ;
    }
}