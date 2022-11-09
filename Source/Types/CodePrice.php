<?php 

namespace Source\Types;

use Source\Classes\LineSplitter;
use Source\Classes\CustomizedDriver;
use Source\Interfaces\DriverInterface;

class CodePrice implements DriverInterface
{
    use CustomizedDriver;

    public static function getRegex(): string 
    {
        return "/^10102/";
    }

    public static function getSplitter(): LineSplitter
    {
        return (new LineSplitter())
        ->with("Type", 3)
        ->with("Rubrique", 2)
        ->with("Sequence", 2)
        ->with("FinValidite", 8)
        ->with("AgeMaximal", 3)
        ->with("TypePrestation", 1)
        ->with("Indication", 1)
        ->with("Arborescence", 6, 10)
        ->with("NiveauBas", 12)
        ->with("CodeIdentifiant", 4)
        ->with("Inutilise", 32)
        ;
    }
}