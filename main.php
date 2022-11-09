<?php

use Source\Classes\FileReader;
use SQL\BasicSQLWriter;

require_once "./Source/Loader.php";

if (!is_dir("./tmp"))
    mkdir("./tmp");

if (!is_file("./tmp/LPPTOT702"))
{
    echo "Downloading File...";
    copy("http://www.codage.ext.cnamts.fr/f_mediam/fo/tips/LPPTOT702.zip", "./tmp/LPPTOT702.zip");

    if (!is_file("./tmp/LPPTOT702.zip"))
    {
        echo "Cannot download file !\n";
        die;
    }
    
    echo "Done\n";

    $archive = new ZipArchive();
    $archive->open("./tmp/LPPTOT702.zip");
    $archive->extractTo("./tmp/");
    $archive->close();
    unlink("./tmp/LPPTOT702.zip");
}

$writer = new BasicSQLWriter();

$reader = new FileReader("./tmp/LPPTOT702", $writer);