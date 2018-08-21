<?php

// Run:
// cp Nook*/*.prf* All
// to get all the prfs in one folder


$directory = "/home/james/EMF/FirstAid/Archive/2014/PRFS-copy/";

$incidents = [];

$dir = new DirectoryIterator($directory);
foreach ($dir as $fileinfo) {
    if (!$fileinfo->isDot()) {
        if ($fileinfo->getExtension() == "txt") {
            $incidents[] = processPRF($fileinfo);
        }
    }
}

/*$headers = ['date', 'type', 'hospital', 'own_transport', 'public_transport', 'ambulance', 'taxi'];

$string = "";

foreach ($headers as $header) {
    $string .= '"' . $header . '",';
}

$string .= "\n";*/

$headerDone = false;
foreach ($incidents as $incident) {
    if ($headerDone === false) {
        $headers = array_keys($incident);
        $string = "";

        foreach ($headers as $header) {
            $string .= '"' . $header . '",';
        }

        $string .= "\n";
        $headerDone = true;
    }

    foreach ($headers as $header) {
        $string .= '"' . $incident[$header] . '",';
    }
    $string .= "\n";
}

file_put_contents($directory . "all-prsf.csv", $string);


function processPRF($fileinfo)
{
    $fileobject = $fileinfo->openFile('r');

    $file = $fileobject->fread(250000);

    $lines = explode("\n", $file);

    $incident = [];

    foreach ($lines as $line) {
        if (strpos($line, ':') !== false) {
            $parts = explode(': ', $line);
            $incident[$parts[0]] = $parts[1];
        }
    }

    return $incident;
}