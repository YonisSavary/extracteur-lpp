<?php 

namespace Source\Types;

use Source\Classes\RecordSplitter;
use Source\Classes\BasicRecordType;
use Source\Classes\Utils;
use Source\Interfaces\RecordTypeInterface;

class CodePrice implements RecordTypeInterface
{
    use BasicRecordType;

    public static function getRegex(): string 
    {
        return "/^11001/";
    }

    public static function getSplitter(): RecordSplitter
    {
        return (new RecordSplitter())
        ->with("Type d'enregistrement", 3)
        ->with("Rubrique", 2)
        ->with("Séquence", 2)
        ->with("Date d'effet / début de validité", 8, 1, [Utils::class, "convertDate"])
        ->with("Date fin d'historique", 8, 1, [Utils::class, "convertDate"])

        ->with("Nature de prestation", 3)
        ->with("Top entente préalable", 1, 1, [Utils::class, "convertBool"])
        ->with("Date de l'arrêté ministériel", 8, 1, [Utils::class, "convertDate"])
        ->with("Date de plublication au J.O.", 8, 1, [Utils::class, "convertDate"])

        ->with("Indication PU sur devis", 1)
        ->with("Tarif de référence", 10, 1, [Utils::class, "convertPrice"])
        ->with("Coefficients majorations des DOM", 4, 6, [Utils::class, "convertMajoration"])
        ->with("Quantité maximale", 3)
        ->with("Montant maximal", 10)
        ->with("Prix unitaire réglementé", 10, 1, [Utils::class, "convertPrice"])
        ->with("Prise en charge particulière", 2, 3)
        ->with("Inutilisé", 21)
        ;
    }
}