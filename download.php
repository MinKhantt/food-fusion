<?php
if(!empty($_GET['file'])) {
    $fileName = basename($_GET['file']);
    $filePath = 'downloads/' . $fileName;

    if(!empty($fileName) && file_exists($filePath)) {
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$fileName");
        header("Content-Type: application/zip");
        header("Content-Transfer-Encoding: binary");

        readfile($filePath);
        exit;
    }
    else {
        $error = "File not found.";
    }
}

if(!empty($_GET['image'])) {
    $fileName = basename($_GET['image']);
    $filePath = 'images/edu-resources' . $fileName;

    if(!empty($fileName) && file_exists($filePath)) {
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$fileName");
        header("Content-Type: application/zip");
        header("Content-Transfer-Encoding: binary");

        readfile($filePath);
        exit;
    }
    else {
        $error = "Image not found.";
    }
}
?>