<?php

namespace YonisSavary\ExtracteurLPP\Interfaces;

interface RecordTypeInterface
{
    public static function handle(string $line, DataAdapterInterface &$writer);
}
