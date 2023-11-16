<?php

namespace YonisSavary\ExtracteurLPP\RecordTypes;

use YonisSavary\ExtracteurLPP\Classes\RecordSplitter;
use YonisSavary\ExtracteurLPP\Classes\BasicRecordType;
use YonisSavary\ExtracteurLPP\Interfaces\RecordTypeInterface;

class Incompatibility implements RecordTypeInterface
{
    use BasicRecordType;

    public static function getRegex(): string
    {
        return "/^12001/";
    }

    public static function getSplitter(): RecordSplitter
    {
        return (new RecordSplitter())
        ->with("Type d'enregistrement", 3)
        ->with("Rubrique", 2)
        ->with("Séquence", 2)
        ->with("Code référence LPP incompatible", 13, 9)
        ->with("Inutilisé", 4)
        ;
    }
}