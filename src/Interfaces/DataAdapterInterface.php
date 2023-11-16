<?php

namespace YonisSavary\ExtracteurLPP\Interfaces;

interface DataAdapterInterface
{
    public function write(array $object, string $class);
    public function getPath(): string;
    public function __construct(string $outPath);
}