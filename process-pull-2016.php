<?php

// Run:
// cp Nook*/*.prf* All
// to get all the prfs in one folder

require 'vendor/autoload.php';

use Carbon\Carbon;


$directory = "/home/james/EMF/FirstAid/Archive/2016/ePRFs-copy/";

$incidents = [];

$dir = new DirectoryIterator($directory);
foreach ($dir as $fileinfo) {
    if (!$fileinfo->isDot()) {
        if ($fileinfo->getExtension() == "txt") {
            $incidents[] = processPRF($fileinfo);
        }
    }
}

$headers = ['file', 'date', 'type', 'response', 'airway', 'breathing', 'circulation', 'hospital', 'own_transport', 'public_transport', 'ambulance', 'taxi', 'none', 'airway_opened', 'wound_cleaned', 'wound_dressed', 'rice', 'adhesive_dressing', 'sling', 'splint', 'recovery_position', 'other'];

 

$string = "";

foreach ($headers as $header) {
    $string .= '"' . $header . '",';
}

$string .= "\n";

foreach ($incidents as $incident) {
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

    // get rid of newlines
    $file = str_replace("\n", '', $file);

    // get rid of the JPEG
    $xml = simplexml_load_string(preg_replace('/\*\*\*JPEG_SIGNATURE\*\*\*.*/', '', $file));

    $incident = [
        'file'  =>  $fileinfo->getFilename(),
        'date'  =>  process_date($xml->incident->time),
        'type'  =>  $xml->primary->presenting,
        'response'  =>  $xml->primary->response,
        'airway'    =>  $xml->primary->airway,
        'breathing' =>  $xml->primary->breathing,
        'circulation'   =>  $xml->primary->circulation,
        'hospital' =>   $xml->discharge->hospital,
        'own_transport' =>   $xml->discharge->own_transport,
        'public_transport'  =>   $xml->discharge->public_transport,
        'ambulance' =>   $xml->discharge->ambulance,
        'taxi'  =>   $xml->discharge->taxi,
        'none'  =>  $xml->treatment->none,
        'airway_opened' =>  $xml->treatment->airway_opened,
        'wound_cleaned' =>  $xml->treatment->wound_cleaned,
        'wound_dressed' =>  $xml->treatment->wound_dressed,
        'rice'  =>  $xml->treatment->rice,
        'adhesive_dressing' =>  $xml->treatment->adhesive_dressing,
        'sling' =>  $xml->treatment->sling,
        'splint'    =>  $xml->treatment->splint,
        'recovery_position' =>  $xml->treatment->recovery_position,
        'other' =>  $xml->treatment->other,
    ];

    return $incident; 

}

function process_date($prfDate)
{
    // prfDate in this format:
    // Sun Aug 07 12:45:07 Europe/London 2016
    // Timezone is BST
    
    $date = Carbon::createFromFormat("D M d H:i:s e Y", $prfDate);

    return $date->toIso8601String();
}