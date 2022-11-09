<?php 

namespace Source\Types;

use Source\Classes\LineSplitter;
use Source\Classes\CustomizedDriver;
use Source\Interfaces\DriverInterface;

class Historical implements DriverInterface
{
    use CustomizedDriver;

    public static function getRegex(): string 
    {
        return "/^11001/";
    }

    public static function getSplitter(): LineSplitter
    {
        return (new LineSplitter())
        ->with("Type", 3)
        ->with("Rubrique", 2)
        ->with("Sequence", 2)
        ->with("DateDebut", 8)
        ->with("DateFin", 8)

        ->with("NaturePrestation", 3)
        ->with("TopEntente", 1)
        ->with("DateArrete", 8)
        ->with("DatePublication", 8)

        ->with("Indication", 1)
        ->with("Tarif", 10)
        ->with("CoefficientsDOM", 4, 6)
        ->with("QuantiteMax", 3)
        ->with("MontantMax", 10)
        ->with("PrixUnitaire", 10)
        ->with("PriseEnCharge", 2, 3)
        ->with("Inutilise", 21)
        ;
    }
}