<?php

namespace App\Helpers\Docx;

use DocxMerge\DocxMerge;

class DocxMergeHelper
{
    public static function merge(array $paths, string $destination)
    {
        $dm = new DocxMerge();
        $dm->merge($paths, $destination);
    }
}
