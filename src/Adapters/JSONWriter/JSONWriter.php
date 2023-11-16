<?php

namespace YonisSavary\ExtracteurLPP\Adapters\JSONWriter;

use Exception;
use Throwable;
use YonisSavary\ExtracteurLPP\Classes\Utils;
use YonisSavary\ExtracteurLPP\Interfaces\DataAdapterInterface;
use YonisSavary\ExtracteurLPP\RecordTypes\Code;
use YonisSavary\ExtracteurLPP\RecordTypes\CodeDescription;
use YonisSavary\ExtracteurLPP\RecordTypes\CodePrice;
use YonisSavary\ExtracteurLPP\RecordTypes\Compatibility;
use YonisSavary\ExtracteurLPP\RecordTypes\Incompatibility;

class JSONWriter implements DataAdapterInterface
{
    public string $path;
    public array $data = [
        "codes" => [],
        "compatibilites" => [],
        "incompatibilites" => []
    ];
    public array $lasts=[];

    public function write(array $object, string $class)
    {
        switch ($class)
        {
            case Code::class           : $this->writeCode($object); break;
            case CodeDescription::class: $this->writeCodeDescription($object); break;
            case CodePrice::class:       $this->writeCodePrice($object); break;
            case Compatibility::class:   $this->writeCompatibility($object); break;
            case Incompatibility::class: $this->writeIncompatibility($object); break;
        }

        $this->lasts[$class] = $object;
    }

    public function __construct(string $outPath)
    {
        $this->path = $outPath . "/JSONWriter.json";
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function __destruct()
    {
        Utils::printLine("[writer] Initializing JSON Writer");

        file_put_contents(
            $this->path,
            json_encode($this->data, JSON_PRETTY_PRINT|JSON_THROW_ON_ERROR| JSON_INVALID_UTF8_IGNORE)
        );
    }

    public function writeCode($object)
    {
        $code = $object["Code"];

        $this->data["codes"][$code] = [
            "type_enregistrement" => $object["Type d'enregistrement"],
            "rubrique" => $object["Rubrique"],
            "sequence" => $object["Séquence"],
            "code" => $object["Code"],
            "libelle_reduit" => $object["Libellé réduit"],
            "numeros_de_reference_medicale" => $object["Numéros de référence médicale"],
            "inutilise" => $object["Inutilisé"],
            "code" => $code,
            "prix" => []
        ];
    }

    public function writeCodePrice($object)
    {
        $code = $this->lasts[Code::class]["Code"];

        $this->data["codes"][$code]["prix"][] = [
            "debut_de_validite"                => $object["Date d'effet / début de validité"],
            "date_fin_dhistorique"             => $object["Date fin d'historique"],
            "nature_de_prestation"             => $object["Nature de prestation"],
            "top_entente_prealable"            => $object["Top entente préalable"],
            "date_de_larrete_ministeriel"      => $object["Date de l'arrêté ministériel"],
            "date_de_plublication_au_jo"       => $object["Date de plublication au J.O."],
            "indication_pu_sur_devis"          => $object["Indication PU sur devis"],
            "tarif_de_reference"               => $object["Tarif de référence"],
            "coefficients_majorations_des_dom" => $object["Coefficients majorations des DOM"],
            "quantite_maximale"                => $object["Quantité maximale"],
            "montant_maximal"                  => $object["Montant maximal"],
            "prix_unitaire_reglemente"         => $object["Prix unitaire réglementé"],
        ];
    }


    public function writeCodeDescription($object)
    {
        $codeName = $this->lasts[Code::class]["Code"];

        $code = &$this->data["codes"][$codeName];

        $code["date_de_fin_de_validite"]    = $object["Date de fin de validité"];
        $code["age_maximal"]                = $object["Age maximal"];
        $code["type_de_prestation_fournie"] = $object["Type de prestation fournie"];
        $code["indication_medicale"]        = $object["Indication médicale"];
    }


    public function writeCompatibility($object)
    {
        $parent = $this->lasts[Code::class]["Code"];
        foreach ($object["Code référence LPP compatible"] as $code)
        {
            if ($code == "")
                continue;

            $this->data["compatibilites"][] = [$parent, $code];
        }
    }


    public function writeIncompatibility($object)
    {
        $parent = $this->lasts[Code::class]["Code"];
        foreach ($object["Code référence LPP incompatible"] as $code)
        {
            if ($code == "")
                continue;

            $this->data["incompatibilites"][] = [$parent, $code];
        }
    }
}