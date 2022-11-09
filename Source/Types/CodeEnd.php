<?php 

namespace Source\Types;

use Source\Classes\LineSplitter;
use Source\Classes\CustomizedDriver;
use Source\Interfaces\DriverInterface;

class CodeEnd implements DriverInterface
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
        ->with("Sequence", 2)
        ->with("Rubrique", 2)
        ->with("NombreEnregistrements", 5)
        ->with("Inutilise", 116)
        ;
    }
}