<?php 

namespace Source\Interfaces;

use stdClass;

interface SQLWriterInterface
{
    public function write(array $object, string $class);
}