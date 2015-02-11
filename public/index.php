<?php

session_start();

$config = require_once('../config.php');
require_once '../vendor/autoload.php';

require_once '../services.php';

$framework = $di->newInstance('Masterclass\FrontController\MasterController');
echo $framework->execute();