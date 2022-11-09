<?php 

namespace Source\Classes;

use Source\Classes\LineSplitter;
use Source\Interfaces\SQLWriterInterface;

trait CustomizedDriver
{
    /** @var LineSplitter */
    static $splitter = false;

    public static function getSplitter(): LineSplitter
    {
        return new LineSplitter;
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

        return $object;
    }
}