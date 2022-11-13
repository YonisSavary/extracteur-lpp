<?php 

namespace Source\Classes;

use Exception;
use Source\Interfaces\SQLWriterInterface;
use Source\Types\Code;
use Source\Types\CodeDescription;
use Source\Types\CodeEnd;
use Source\Types\Compatibility;
use Source\Types\FileEnd;
use Source\Types\FileStart;
use Source\Types\CodePrice;
use Source\Types\Incompatibility;

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

    public function __construct(string $path, SQLWriterInterface $writer)
    {
        if (!$file = fopen($path, "r"))
            throw new Exception("Cannot open [$path]");

        $recordsNumber = 0;
        echo "[reader] Starting to read file (# = 1000 records read)...\n";
        while ($data = fgets($file, 128 + 1))
        {
            foreach (self::DRIVERS as $driver)
                $driver::handle($data, $writer);
                
            if ($recordsNumber % 1000 == 0)
                echo "#";

            $recordsNumber++;
        }
        echo "\n";
        echo "[reader] Read $recordsNumber records\n";

        fclose($file);
    }
}