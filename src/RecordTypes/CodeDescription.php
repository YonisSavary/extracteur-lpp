<?php

namespace YonisSavary\ExtracteurLPP\RecordTypes;

use YonisSavary\ExtracteurLPP\Classes\RecordSplitter;
use YonisSavary\ExtracteurLPP\Classes\BasicRecordType;
use YonisSavary\ExtracteurLPP\Classes\Utils;
use YonisSavary\ExtracteurLPP\Interfaces\RecordTypeInterface;

class CodeDescription implements RecordTypeInterface
{
    use BasicRecordType;

    public static function getRegex(): string
    {
        return "/^10102/";
    }

    public static function getSplitter(): RecordSplitter
    {
        return (new RecordSplitter())
        ->with("Type d'enregistrement", 3)
        ->with("Rubrique", 2)
        ->with("Séquence", 2)
        ->with("Date de fin de validité", 8, 1, [Utils::class, "convertDate"])
        ->with("Age maximal", 3)
        ->with("Type de prestation fournie", 1)
        ->with("Indication médicale", 1, 1, [Utils::class, "convertBool"])
        ->with("Arborescence", 6, 10)
        ->with("Niveau le plus bas dans l'arborescence", 12)
        ->with("Code identifiant de prothèse", 4)
        ->with("Inutilisé", 32)
        ;
    }
}