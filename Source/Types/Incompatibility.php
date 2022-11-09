<?php 

namespace Source\Types;

use Source\Classes\LineSplitter;
use Source\Classes\CustomizedDriver;
use Source\Interfaces\DriverInterface;

class Incompatibility implements DriverInterface
{
    use CustomizedDriver;

    public static function getRegex(): string 
    {
        return "/^12001/";
    }

    public static function getSplitter(): LineSplitter
    {
        return (new LineSplitter())
        ->with("Type", 3)
        ->with("Rubrique", 2)
        ->with("Sequence", 2)
        ->with("Reference", 13, 9)
        ->with("Inutilise", 4)
        ;
    }
}