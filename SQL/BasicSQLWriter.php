<?php 

namespace SQL;

use Source\Interfaces\SQLWriterInterface;
use Source\Types\Code;
use Source\Types\CodeEnd;
use Source\Types\Compatibility;
use Source\Types\FileEnd;
use Source\Types\FileStart;
use Source\Types\Historical;
use Source\Types\Incompatibility;
use stdClass;

class BasicSQLWriter implements SQLWriterInterface
{
    public function write(stdClass $object, string $class)
    {
        switch ($class)
        {
            case Code::class:
                break;
            case CodeEnd::class:
                break;
            case Compatibility::class:
                break;
            case FileEnd::class:
                break;
            case FileStart::class:
                break;
            case Historical::class:
                break;
            case Incompatibility::class:
                break;
        }
    }
}