<?php 

namespace Source\Classes;

use Exception;
use Source\Interfaces\SQLWriterInterface;
use Source\Types\Code;
use Source\Types\CodeEnd;
use Source\Types\Compatibility;
use Source\Types\FileEnd;
use Source\Types\FileStart;
use Source\Types\Historical;
use Source\Types\Incompatibility;

class FileReader 
{
    /**
     * @var array<DriverInterface>
     */
    const DRIVERS = [
        Code::class,
        CodeEnd::class,
        Compatibility::class,
        FileEnd::class,
        FileStart::class,
        Historical::class,
        Incompatibility::class
    ];

    public function __construct(string $path, SQLWriterInterface $writer)
    {
        if (!$file = fopen($path, "r"))
            throw new Exception("Cannot open [$path]");

        $recordsNumber = 0;
        while ($data = fgets($file, 128 + 1))
        {
            foreach (self::DRIVERS as $driver)
                $driver::handle($data, $writer);

            $recordsNumber++;
        }

        echo "Read $recordsNumber records\n";

        fclose($file);
    }
}