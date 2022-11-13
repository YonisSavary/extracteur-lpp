<?php 

namespace SQL\Basic;

use Exception;
use stdClass;
use Source\Interfaces\SQLWriterInterface;
use Source\Types\Code;
use Source\Types\CodeDescription;
use Source\Types\CodeEnd;
use Source\Types\Compatibility;
use Source\Types\CodePrice;
use Source\Types\Incompatibility;

class BasicSQLWriter implements SQLWriterInterface
{
    const PATH = "./tmp/out.sql";
    const VERBOSE_PATH = "./tmp/verbose.dump";

    const DO_VERBOSE = false;


    protected $lasts = [];

    protected $writer = false;
    protected $verbose = false;

    protected $endContent = [];


    public function __construct()
    {
        echo "[writer] Initializing SQL Writer\n";

        if (!$this->writer = fopen(self::PATH, "w"))
            throw new Exception("[".self::class."] cannot write in ".self::PATH);

        fwrite($this->writer, "-- Basic SQL Writer\n");
        fwrite($this->writer, "-- Ce schéma contient les informations essentielles sur les différents codes LPP\n");
        fwrite($this->writer, "-- Retrouvez le schema SQL dans ". dirname(__FILE__) . DIRECTORY_SEPARATOR . "SCHEMA.sql\n");
        fwrite($this->writer, "-- ansi que les (in)compatibilitées à la fin de ce fichier\n\n");

        if (self::DO_VERBOSE)
            $this->verbose = fopen(self::VERBOSE_PATH, "w");
    }


    public function __destruct()
    {
        $used = 0;
        foreach ($this->endContent as $value)
            $used += strlen($value);
        echo "[writer] Memory for end-content : ".($used/1024)." ko\n";
        echo "[writer] Output size : ~". round(ftell($this->writer)/(1024*1024), 2)." Mo\n";

        fwrite($this->writer, join("\n", $this->endContent)."\n");
        fclose($this->writer);
        if ($this->verbose) 
            fclose($this->verbose);
    }


    public function write(array $object, string $class)
    {
        switch ($class)
        {
            case CodeDescription::class: $this->writeCodeDescription($object); break;
            case CodePrice::class:       $this->writeCodePrice($object); break;
            case CodeEnd::class:         $this->writeCodeEnd($object); break;
            case Compatibility::class:   $this->writeCompatibility($object); break;
            case Incompatibility::class: $this->writeIncompatibility($object); break;
        }

        $this->lasts[$class] = $object;

        if ($this->verbose)
        {
            fwrite($this->verbose, "\n$class\n");
            fwrite($this->verbose, print_r($object, true));
            fwrite($this->verbose, "\n------------------------\n");
        }
    }


    public function writeSQL(string $query, array $context, bool $endMode=false)
    {
        $query = preg_replace("/(\n|\r)/", "", $query);
        $query = preg_replace("/ {2,}/", " ", $query);
        $count = 0;

        while ($pos = strpos($query, "?"))
        {
            $value = ($context[$count] ?? "null");

            if (strToLower($value) !== "null")
                $value = "'". preg_replace("/(\\\\|'|\")/", '$1$1', $value) . "'";

            $query = substr($query, 0, $pos) . $value . substr($query, $pos+1);
            $count++;
        }

        if ($endMode)
            $this->endContent[] = $query;
        else
            fwrite($this->writer, $query."\n");
    }


    public function writeCodeEnd($_)
    {
        fwrite($this->writer, "-- FIN DU CODE ". $this->lasts[Code::class]["Code"] . "\n\n");
    }


    public function writeCodePrice($object)
    {
        $this->writeSQL(
            "INSERT IGNORE INTO lpp_code_prix (
                fk_code,
                debut_validite,
                fin_validite,
                nature_prestation,
                entente_prealable,
                date_arrete,
                date_publication,
                indication_pu_devis,
                tarif_reference,
                majoration_971,
                majoration_972,
                majoration_973,
                majoration_974,
                majoration_975,
                majoration_976,
                quantite_maximale,
                montant_maximal,
                prix_unitaire
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);"
        , [
            $this->lasts[Code::class]["Code"],
            $object["Date d'effet / début de validité"],
            $object["Date fin d'historique"],
            $object["Nature de prestation"],
            $object["Top entente préalable"],
            $object["Date de l'arrêté ministériel"],
            $object["Date de plublication au J.O."],
            $object["Indication PU sur devis"],
            $object["Tarif de référence"],
            ...$object["Coefficients majorations des DOM"],
            $object["Quantité maximale"],
            $object["Montant maximal"],
            $object["Prix unitaire réglementé"]
        ]); 
    }


    public function writeCodeDescription($object)
    {
        $this->writeSQL(
            "INSERT IGNORE INTO lpp_code (
                code,
                libelle,
                fin_validite,
                age_maximal,
                type_prestation,
                indication_medicale
            ) VALUES (?, ?, ?, ?, ?, ?);
        ", [
            $this->lasts[Code::class]["Code"],
            $this->lasts[Code::class]["Libellé réduit"],
            $object["Date de fin de validité"],
            $object["Age maximal"],
            $object["Type de prestation fournie"],
            $object["Indication médicale"],
        ]);
    }


    public function writeCompatibility($object)
    {
        $parent = $this->lasts[Code::class]["Code"];
        foreach ($object["Code référence LPP compatible"] as $code)
        {
            if ($code == "")
                continue;

            $this->writeSQL(
                "INSERT IGNORE INTO lpp_compatibilite (
                    code,
                    reference
                ) VALUES (?, ?);
            ", [$parent, $code], true);
        }
    }

    
    public function writeIncompatibility($object)
    {
        $parent = $this->lasts[Code::class]["Code"];
        foreach ($object["Code référence LPP incompatible"] as $code)
        {
            if ($code == "")
                continue;
                
            $this->writeSQL(
                "INSERT IGNORE INTO lpp_incompatibilite (
                    code,
                    reference
                ) VALUES (?, ?);
            ", [$parent, $code], true);
        }
    }
}