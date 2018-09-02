<?php

use Carbon\Carbon;
use Flatbase\Flatbase;
use Flatbase\Storage\Filesystem;

require '../vendor/autoload.php';
require '../blade.php';

if (!isset($_POST['go'])) {
    echo $blade->render('error.error', ['msg' => 'You must submit the event data']);
    die;
}

$startDate = Carbon::parse($_POST['eventStart']);
$endDate = Carbon::parse($_POST['eventEnd']);
$timestrings = [];

// the last date we have a PRF for the current event for
$passedTimestrings = [];

$series = [];
$counts = [];
$totals = [
    'current'   => 0,
    'previous'  => 0,
];

// we need an entry for each date in the previous data set, even if it is 0
// we will set the actual data later
$series['previous'] = [
    'type'      => 'line',
    'name'      => $_POST['previousEventLabel'],
    'data'      => []
];

$categories = [];
$date = $startDate->copy();
while ($date->lte($endDate)) {
    $categories['previous'][$date->format('D Hi')] = 0;
    $timestrings[$date->format('D Hi')] = $date->copy();

    $date->addHour();
}

// loop over the current event and get the data out
$storage = new Filesystem($_POST['currentEventPath'] . 'stats-data/');
$flatbase = new Flatbase($storage);

$prfs = $flatbase->read()
        ->in('prfs')
        ->sort('date')
        ->get();

// initial count
for ($i = 0; $i < count($prfs); $i++) {
    $timestring = $prfs[$i]['prf']->getDate()->format('D H') . '00';

    if (!in_array($timestring, array_keys($timestrings))) {
        // not during festival hours
        continue;
    }

    // is this the last one?
    if (!in_array($timestring, $passedTimestrings)) {
        $passedTimestrings[] = $timestring;
    }

    $category = $prfs[$i]['prf']->getCategory();

    if (!isset($categories[$category])) {
        $categories[$category] = [];
    }

    if (!isset($categories[$category][$timestring])) {
        $categories[$category][$timestring] = 0;
    }

    $categories[$category][$timestring]++;

    if (!isset($counts[$category])) {
        $counts[$category] = [
            'current'   => 0,
            'previous'  => 0,
        ];
    }

    $counts[$category]['current']++;
    $totals['current']++;
}

// fill out the passed timestrings
$lastPassed = $passedTimestrings[count($passedTimestrings)-1];
$passedTimestrings = [];
$lookupStrings = array_keys($timestrings);
for ($i = 0; $i < count($timestrings); $i++) {
    $passedTimestrings[] = $lookupStrings[$i];
    if ($lookupStrings[$i] == $lastPassed) {
        break;
    }
}


// loop over the previous event and get the data out
$storage = new Filesystem($_POST['previousEventPath'] . 'stats-data/');
$flatbase = new Flatbase($storage);

$prfs = $flatbase->read()
        ->in('prfs')
        ->sort('date')
        ->get();

// initial count
for ($i = 0; $i < count($prfs); $i++) {
    $timestring = $prfs[$i]['prf']->getDate()->format('D H') . '00';

    if (!in_array($timestring, array_keys($timestrings))) {
        // not during festival hours
        continue;
    }

    if (!isset($categories['previous'][$timestring])) {
        $categories['previous'][$timestring] = 0;
    }

    $categories['previous'][$timestring]++;

    $category = $prfs[$i]['prf']->getCategory();

    if (!isset($counts[$category])) {
        $counts[$category] = [
            'current'   => 0,
            'previous'  => 0,
        ];
    }

    if (in_array($timestring, $passedTimestrings)) {
        $counts[$category]['previous']++;
        $totals['previous']++;
    }
}

// transform the data into series
foreach ($categories as $category => $data) {
    if (!isset($series[$category])) {
        $series[$category] = [
            'name'  => $category,
            'data'  => [],
        ];
    }

    foreach ($data as $timestring => $count) {
        $series[$category]['data'][] = [$timestrings[$timestring]->timestamp * 1000, $count];
    }
}

// build the JSON object for the chart
$chartSeries = [];
foreach ($series as $data) {
    $chartSeries[] = $data;
}


$with = [
    'title'     => $_POST['eventTitle'],
    'start'     => $startDate->timestamp * 1000,
    'end'       => $endDate->timestamp * 1000,
    'series'    => $chartSeries,
    'counts'    => $counts,
    'totals'    => $totals,
    'current'   => $_POST['currentEventLabel'],
    'previous'  => $_POST['previousEventLabel'],
    'lastDate'  => $passedTimestrings[count($passedTimestrings)-1],
];

echo $blade->render('stats.main', $with);
