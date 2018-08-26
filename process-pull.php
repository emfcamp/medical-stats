<?php

use Flatbase\Flatbase;
use EMFCamp\Medical\ePrf;
use Flatbase\Storage\Filesystem;

/**
 * Expects the path to look like:
 *
 * Path
 * |
 * ├── combined
 * ├── nooks
 * |   ├── nook1
 * |   ├── nook2
 * |   ├── nook3
 * ├── stats-data
 */

require 'vendor/autoload.php';

$options = getopt("", [
    "input:",
    "debug"
    ]);

if (!isset($options['input'])) {
    echo("Need an input argument to continue;");
    die;
} elseif (!file_exists($options['input'])) {
    echo("Input path doesn't exist");
    die;
} else {
    $inputPath = $options['input'];

    if ($inputPath[strlen($inputPath) - 1] !== "/") {
        $inputPath .= "/";
    }
}

$debug = false;
if (isset($options['debug'])) {
    $debug = true;
}

$prfList = checkForPrfs($inputPath . 'nooks/');

if (count($prfList)  === 0) {
    echo "No PRFs found in input path";
    die;
}

// ok, we have data to deal with, so spin up the flatfile database
$storage = new Filesystem($inputPath . 'stats-data/');
$flatbase = new Flatbase($storage);

$newPath = $inputPath . 'combined/';
foreach ($prfList as $prfPaths) {
    $encrypted = new SplFileInfo($prfPaths['encrypted']);
    $decrypted = new SplFileInfo($prfPaths['decrypted']);

    // move encrypted to combined folder
    // but check that it doesn't name clash
    $newFile = $newPath . $encrypted->getBasename();
    $count = 1;
    while(file_exists($newFile)) {
        $count++;
        $newFile = $newPath . $encrypted->getBasename(".prf") . "(" . $count .").prf";
    }

    if ($debug) {
        echo("Not moving: " . $encrypted->getPathname() . " to " . $newFile . "\n");
    } else {
        rename($encrypted->getPathname(), $newFile);
    }
    
    // build PRF object from decrypted
    $prf = new ePrf();
    $contents = file_get_contents($decrypted->getPathname());
    // get rid of newlines
    $contents = str_replace("\n", '', $contents);
    // get rid of embedded JPEG
    $xml = preg_replace('/\*\*\*JPEG_SIGNATURE\*\*\*.*/', '', $contents);

    if ($prf->createFromXML($xml) === false) {
        echo("There was an issue with a PRF and it was skipped:\n" . $decrypted->getPathname() . "\n");
        continue;
    }


    if ($debug) {
        var_dump($prf);
    }
    
    // save PRF object in stats database
    if (!$debug) {
        $flatbase->insert()->in('prfs')->set([
            'id'    => $prf->getId(),
            'date'  => $prf->getDateString(),
            'year'  => $prf->getYear(),
            'month' => $prf->getMonth(),
            'day'   => $prf->getDay(),
            'hour'  => $prf->getHour(),
            'prf'   => $prf
        ])->execute();
    }
     
    // remove decrypted
    if ($debug) {
        echo("Not removing: " . $decrypted->getPathname() . "\n");
    } else {
        unlink($decrypted->getPathname());
    }
}

echo "All PRFs have been processed";


function checkForPrfs($path)
{
    // we are expecting the path to have multiple folders, each with
    // encrypted and decrypted prfs in it
    
    $prfList = [];

    $dir = new DirectoryIterator($path);
    foreach ($dir as $fileinfo) {
        if (!$fileinfo->isDot()) {
            if ($fileinfo->isDir()) {
                $prfList = array_merge($prfList, getPrfs($fileinfo->getPathname()));
            }
        }
    }

    return $prfList;
}

function getPrfs($path)
{
    $prfList = [];

    $dir = new DirectoryIterator($path);
    foreach ($dir as $fileinfo) {
        if (strpos($fileinfo->getBasename(), '.prf')) {
            $id = str_replace(".prf", "", $fileinfo->getBasename(".txt"));
            if (!isset($prfList[$id])) {
                $prfList[$id] = [];
            }

            if ($fileinfo->getExtension() === "txt") {
                $prfList[$id]['decrypted'] = $fileinfo->getPathname();
            } elseif ($fileinfo->getExtension() === "prf") {
                $prfList[$id]['encrypted'] = $fileinfo->getPathname();
            }
        }
    }

    return $prfList;
}