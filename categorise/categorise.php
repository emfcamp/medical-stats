<?php

use Flatbase\Flatbase;
use Delight\Cookie\Cookie;
use Flatbase\Storage\Filesystem;

require '../vendor/autoload.php';
require '../blade.php';

// if we are just starting
if (isset($_POST['path'])) {
    $path = checkPath($_POST['path']);

    if ($path) {
        $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
        Cookie::setcookie('path', $path, time()+60*60*24*365, '/', $domain, false);
    } else {
        echo $blade->render('error.error', ['msg' => 'Path not a valid Medical Event']);
        die;
    }
}

// bootstrap the DB
if (Cookie::exists('path')) {
    $path = Cookie::get('path');
}

$storage = new Filesystem($path . 'stats-data/');
$flatbase = new Flatbase($storage);

if (isset($_POST['save'])) {
    // save the record
    $prf = $flatbase->read()
        ->in('prfs')
        ->where('id', '==', $_POST['id'])
        ->get();

    if (count($prf) == 1) {
        $prf = $prf[0];
        if (isset($prf['prf'])) {
            $categoryLookup = $prf['prf']->getPossibleCategories();

            if (isset($categoryLookup[$_POST['category']]) and
                in_array($_POST['severity'], $categoryLookup[$_POST['category']]['severities'])) {

                $prf['prf']->setCategory($_POST['category']);
                $prf['prf']->setSeverity($_POST['severity']);
                $prf['prf']->setRiddor($_POST['riddor']);

                $flatbase->update()
                    ->in('prfs')
                    ->set([
                        'category'  => $_POST['category'],
                        'severity'  => $_POST['severity'],
                        'riddor'    => $_POST['riddor'] == "true" ? true : false,
                        'prf'       => $prf['prf'],
                    ])
                    ->where('id', '==', $_POST['id'])
                    ->execute();
            }
        }
    }
}

$done = $flatbase->read()
        ->in('prfs')
        ->where('category', '!=', false)
        ->get();

$prfs = $flatbase->read()
        ->in('prfs')
        ->where('category', '==', false)
        ->get();

if (count($prfs) > 0) {
    $currentPrf = $prfs[0];

    $with = [
        'id'        => $currentPrf['id'],
        'title'     => "PRF: " . $currentPrf['prf']->getDate()->toDayDateTimeString(),
        'date'      => $currentPrf['prf']->getDateString(),
        'primary'   => $currentPrf['prf']->getPrimary(),
        'secondary' => $currentPrf['prf']->getSecondary(),
        'treatment' => $currentPrf['prf']->getTreatment(),
        'serious'   => $currentPrf['prf']->getSerious(),
        'discharge' => $currentPrf['prf']->getDischarge(),

        'completed' => count($done),
        'remain'    => count($prfs),
        'total'     => count($done) + count($prfs),
    ];

    $categoryLookup = $currentPrf['prf']->getPossibleCategories();

    $with['categoryLookup'] = $categoryLookup;
    $with['categories'] = array_keys($categoryLookup);



    echo $blade->render('categorise.prf', $with);
} else {
    // finished!
}





function checkPath($path) {
    // we are expecting a 'stats-data' folder, with a 'prfs' flatfile db
    if ($path[strlen($path)-1] != '/') {
        $path .= '/';
    }

    $statsPath = $path . 'stats-data/';

    if (file_exists($statsPath . 'prfs')) {
        $storage = new Filesystem($path . 'stats-data/');
        $flatbase = new Flatbase($storage);

        if (count($flatbase->read()->in('prfs')->get()) > 0) {
            return $path;
        } else {
            return false;
        }
    } else {
        return false;
    }

    $storage = new Filesystem($path . 'stats-data/');
    $flatbase = new Flatbase($storage);

    var_dump($flatbase->read()->in('prfs')->get());

    return false;
}