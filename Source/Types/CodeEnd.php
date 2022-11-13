<?php 

namespace Source\Types;

use Source\Classes\RecordSplitter;
use Source\Classes\BasicRecordType;
use Source\Interfaces\RecordTypeInterface;

class CodeEnd implements RecordTypeInterface
{
    use BasicRecordType;

    public static function getRegex(): string 
    {
        return "/^19901/";
    }

    public static function getSplitter(): RecordSplitter
    {
        return (new RecordSplitter())
        ->with("Type d'enregistrement", 3)
        ->with("Séquence", 2)
        ->with("Rubrique", 2)
        ->with("Nombre d'enregistrements", 5)
        ->with("Inutilisé", 116)
        ;
    }
}