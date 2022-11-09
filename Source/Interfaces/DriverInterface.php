<?php 

namespace Source\Interfaces;

interface DriverInterface
{
    public static function handle(string $line, SQLWriterInterface &$writer);
}
