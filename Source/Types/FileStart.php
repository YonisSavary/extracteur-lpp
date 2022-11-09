<?php 

namespace Source\Types;

use Source\Classes\LineSplitter;
use Source\Classes\CustomizedDriver;
use Source\Interfaces\DriverInterface;

class FileStart implements DriverInterface
{
    use CustomizedDriver;

    public static function getRegex(): string 
    {
        return "/^000/";
    }

    public static function getSplitter(): LineSplitter
    {
        return (new LineSplitter())
        ->with("TypeEnregistrement", 3)
        ->with("TypeEmetteur", 2)
        ->with("NumeroEmetteur", 14)
        ->with("ProgrammeEmetteur", 6)
        ->with("TypeDestinataire", 2)
        ->with("NumeroDestinataire", 14)
        ->with("ProgrammeDestinataire", 6)
        ->with("TypeEchange", 2)
        ->with("IdentifiantFichier", 3)
        ->with("DateCreation", 6)
        ->with("NOEMIE", 24)
        ->with("NumeroChronologie", 5)
        ->with("TypeFichier", 1)
        ->with("UniteMonetaire", 1)
        ->with("NumeroVersion", 4)
        ->with("Inutilise", 35)
        ;
    }
}