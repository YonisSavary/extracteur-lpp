<?php 

namespace Source\Types;

use Source\Classes\LineSplitter;
use Source\Classes\CustomizedDriver;
use Source\Interfaces\DriverInterface;

class Code implements DriverInterface
{
    use CustomizedDriver;

    public static function getRegex(): string 
    {
        return "/^10101/";
    }

    public static function getSplitter(): LineSplitter
    {
        return (new LineSplitter())
        ->with("Type", 3)
        ->with("Rubrique", 2)
        ->with("Sequence", 2)
        ->with("Code", 13)
        ->with("Libelle", 80)
        ->with("NumeroRefMedical", 5, 5)
        ->with("Inutilise", 3)
        ;
    }
}