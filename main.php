<?php

use Source\Classes\FileReader;
use Source\Classes\Utils;
use SQL\Basic\BasicSQLWriter;

require_once "./Source/Loader.php";

if (!is_dir("./tmp"))
    mkdir("./tmp");

$sourceFile = Utils::ensureSourceFile();


$options = getopt("", ["writer::"]);


$class = BasicSQLWriter::class;
if ($customWriter = $options["writer"]??false)
{
    if (!class_exists($customWriter))
        die("Custom writer class [$customWriter] does not exists !");
    echo "Detected writer param ! Using : $customWriter\n";
    $class = $customWriter;
}
$writer = new $class();


$reader = new FileReader($sourceFile, $writer);

return 0;