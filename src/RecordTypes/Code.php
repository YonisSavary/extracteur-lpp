<?php

namespace YonisSavary\ExtracteurLPP\RecordTypes;

use YonisSavary\ExtracteurLPP\Classes\RecordSplitter;
use YonisSavary\ExtracteurLPP\Classes\BasicRecordType;
use YonisSavary\ExtracteurLPP\Interfaces\RecordTypeInterface;

class Code implements RecordTypeInterface
{
    use BasicRecordType;

    public static function getRegex(): string
    {
        return "/^10101/";
    }

    public static function getSplitter(): RecordSplitter
    {
        return (new RecordSplitter())
        ->with("Type d'enregistrement", 3)
        ->with("Rubrique", 2)
        ->with("Séquence", 2)
        ->with("Code", 13)
        ->with("Libellé réduit", 80)
        ->with("Numéros de référence médicale", 5, 5)
        ->with("Inutilisé", 3)
        ;
    }
}