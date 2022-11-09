<?php 

namespace Source\Classes;

use stdClass;

class LineSplitter
{
    protected $parts = [];

    public function with(string $name, int $length, int $occurences=1): self
    {
        $this->parts[] = (object)[
            "name"=>$name,
            "length"=>$length,
            "occurences"=>$occurences,
            "isArray" =>$occurences > 1
        ];

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
                $values[] = substr($line, $pointer, $size);
                $pointer += $size;
            }

            $object->$name = ($part->isArray == true)? $values : $values[0];
        }

        return $object;
    }
}