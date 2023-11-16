<?php

namespace YonisSavary\ExtracteurLPP\Classes;

use stdClass;
use YonisSavary\ExtracteurLPP\Interfaces\DataAdapterInterface;

trait BasicRecordType
{
    /**
     * @var RecordSplitter
     */
    static $splitter = false;

    public static function getSplitter(): RecordSplitter
    {
        return new RecordSplitter;
    }

    public static function getRegex(): string
    {
        return "/^$/";
    }

    public static function handle(string $line, DataAdapterInterface &$writer): false|stdClass
    {
        if (!self::$splitter)
            self::$splitter = self::getSplitter();

        if (!preg_match(self::getRegex(), $line))
            return false;

        $object = self::$splitter->split($line);

        $writer->write((array)$object, self::class);

        return $object;
    }
}