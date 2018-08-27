<?php

use Delight\Cookie\Cookie;

require '../vendor/autoload.php';
require '../blade.php';

$variables = [
    'title' =>  'Categorise ePRFs',
    'path'  =>  ''
];

if (Cookie::exists('path')) {
    $variables['path'] = Cookie::get('path');
}

echo $blade->render('categorise.index', $variables);
