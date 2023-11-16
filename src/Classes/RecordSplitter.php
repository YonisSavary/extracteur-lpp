<?php

namespace YonisSavary\ExtracteurLPP\Classes;

use stdClass;

class RecordSplitter
{
    /** @var array<RecordSplitterPart> $parts */
    protected array $parts = [];

    public function with(string $name, int $length, int $occurences=1, callable $mapper=null): self
    {
        $this->parts[] = new RecordSplitterPart(
            $name,
            $length,
            $occurences,
            $mapper
        );

        return $this;
    }

    public function split(string $line): stdClass
    {
        $object = new stdClass;

        $pointer = 0;
        foreach ($this->parts as $part)
        {
            $size = $part->length;
            $name = $part->name;

            $values = [];
            for ($i=0; $i<$part->occurences; $i++)
            {
                $values[] = trim(substr($line, $pointer, $size));
                $pointer += $size;
            }

            if ($part->mapper !== null)
                $values = array_map($part->mapper, $values);

            $object->$name = $part->isArray ?
                $values :
                $values[0]
            ;
        }

        return $object;
    }
}