<?php

namespace YonisSavary\ExtracteurLPP\Classes;

use Exception;
use YonisSavary\ExtracteurLPP\Interfaces\DataAdapterInterface;
use YonisSavary\ExtracteurLPP\RecordTypes\Code;
use YonisSavary\ExtracteurLPP\RecordTypes\CodeDescription;
use YonisSavary\ExtracteurLPP\RecordTypes\CodeEnd;
use YonisSavary\ExtracteurLPP\RecordTypes\Compatibility;
use YonisSavary\ExtracteurLPP\RecordTypes\FileEnd;
use YonisSavary\ExtracteurLPP\RecordTypes\FileStart;
use YonisSavary\ExtracteurLPP\RecordTypes\CodePrice;
use YonisSavary\ExtracteurLPP\RecordTypes\Incompatibility;

class FileReader
{
    /**
     * @var array<RecordTypeInterface>
     */
    const DRIVERS = [
        Code::class,
        CodeDescription::class,
        CodePrice::class,
        CodeEnd::class,
        Compatibility::class,
        FileEnd::class,
        FileStart::class,
        Incompatibility::class
    ];
    protected string $path;
    protected DataAdapterInterface $writer;

    public static function readNXFile(string $path, DataAdapterInterface $writer)
    {
        if (!$file = fopen($path, "r"))
            throw new Exception("Cannot open [$path]");

        $recordsNumber = 0;

        Utils::printLine("[reader] Starting to read file (# = 1000 records read)...");

        while ($data = fgets($file, 128 + 1))
        {
            foreach (self::DRIVERS as $driver)
            {
                if ($driver::handle($data, $writer))
                {
                    $recordsNumber++;
                    break;
                }
            };

            if ($recordsNumber % 1000 == 0)
                Utils::print("#");
        }
        Utils::printLine("\n[reader] Read $recordsNumber records");

        fclose($file);
    }
}