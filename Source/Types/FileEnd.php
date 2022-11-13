<?php 

namespace Source\Types;

use Source\Classes\RecordSplitter;
use Source\Classes\BasicRecordType;
use Source\Interfaces\RecordTypeInterface;

class FileEnd implements RecordTypeInterface
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
        ->with("Informations NOEMIE", 49)
        ->with("Nombre total d'enregistrements", 8)
        ->with("Nombre de codes référence LPP", 6)
        ->with("Sceau du fichier", 10)
        ->with("Inutilisé", 52)
        ;
    }
}