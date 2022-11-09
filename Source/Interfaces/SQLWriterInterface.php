<?php 

namespace Source\Interfaces;

use stdClass;

interface SQLWriterInterface
{
    public function write(stdClass $object, string $class);
}