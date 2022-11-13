<?php 

namespace Source\Classes;

use Source\Classes\RecordSplitter;
use Source\Interfaces\SQLWriterInterface;

trait BasicRecordType
{
    /** @var RecordSplitter */
    static $splitter = false;

    public static function getSplitter(): RecordSplitter
    {
        return new RecordSplitter;
    }

    public static function getRegex(): string 
    {
        return "/^$/";
    }

    public static function handle(string $line, SQLWriterInterface &$writer)
    {
        if (!self::$splitter)
            self::$splitter = self::getSplitter();

        if (!preg_match(self::getRegex(), $line))
            return;

        $object = self::$splitter->split($line);

        $writer->write((array)$object, self::class);

        return $object;
    }
}