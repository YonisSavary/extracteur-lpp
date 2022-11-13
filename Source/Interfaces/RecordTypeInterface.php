<?php 

namespace Source\Interfaces;

interface RecordTypeInterface
{
    public static function handle(string $line, SQLWriterInterface &$writer);
}
