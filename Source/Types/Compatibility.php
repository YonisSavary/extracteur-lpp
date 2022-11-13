<?php 

namespace Source\Types;

use Source\Classes\RecordSplitter;
use Source\Classes\BasicRecordType;
use Source\Interfaces\RecordTypeInterface;

class Compatibility implements RecordTypeInterface
{
    use BasicRecordType;

    public static function getRegex(): string 
    {
        return "/^13001/";
    }

    public static function getSplitter(): RecordSplitter
    {
        return (new RecordSplitter())
        ->with("Type d'enregistrement", 3)
        ->with("Rubrique", 2)
        ->with("Séquence", 2)
        ->with("Code référence LPP compatible", 13, 9)
        ->with("Inutilisé", 4)
        ;
    }
}