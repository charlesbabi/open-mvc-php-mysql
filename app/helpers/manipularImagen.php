<?php

function base64EncodeImage($filename = '', $filetype = '')
{
    if ($filename) {
        $imgbinary = fread(fopen($filename, "r"), filesize($filename));
        return 'data:image/' . $filetype . ';base64,' . base64_encode($imgbinary);
    }
}

function base64EncodePDF($filename = '')
{
    if ($filename) {
        $filebinary = fread(fopen($filename, "r"), filesize($filename));
        return 'data:application/pdf;base64,' . base64_encode($filebinary);
    }
}
