<?php

require '../vendor/autoload.php';
require '../blade.php';

$variables = [];

echo $blade->render('stats.index', $variables);
