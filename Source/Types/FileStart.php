<?php 

namespace Source\Types;

use Source\Classes\RecordSplitter;
use Source\Classes\BasicRecordType;
use Source\Interfaces\RecordTypeInterface;

class FileStart implements RecordTypeInterface
{
    use BasicRecordType;

    public static function getRegex(): string 
    {
        return "/^000/";
    }

    public static function getSplitter(): RecordSplitter
    {
        return (new RecordSplitter())
        ->with("Type d'enregistrement", 3)
        ->with("Type d'émetteur", 2)
        ->with("Numéro émetteur", 14)
        ->with("Programme émetteur", 6)
        ->with("Type de destinataire", 2)
        ->with("Numéro de destinataire", 14)
        ->with("Programme destinataire", 6)
        ->with("Application - type d'échange", 2)
        ->with("Identifiant du fichier", 3)
        ->with("Date de création du fichier", 6)
        ->with("Informations NOEMIE", 24)
        ->with("Numéro chronologie", 5)
        ->with("Type de fichier", 1)
        ->with("Unité monétaire", 1)
        ->with("Numéro de version de norme", 4)
        ->with("Zone Inutilisée", 35)
        ;
    }
}