<?php

namespace YonisSavary\ExtracteurLPP\Classes;

use InvalidArgumentException;

class RecordSplitterPart
{
    public readonly bool $isArray;

    public function __construct(
        public readonly string $name,
        public readonly int $length,
        public readonly int $occurences=1,
        public readonly mixed $mapper=null
    ){
        if ($mapper && (!is_callable($mapper)))
            throw new InvalidArgumentException("\$mapper parameter must be a callable or null value");

        $this->isArray = $this->occurences > 1;
    }
}