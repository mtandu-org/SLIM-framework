<?php
Header("Access-Control-Allow-Origin:*");
Header("Access-Control-Allow-Methods:PUT,POST,GET, DELETE");
Header("Access-Control-Allow-Headers: Origin, X-Requested-With,Content-Type,Accept");
require '../vendor/autoload.php';

$app = new \Slim\App;
 
require '../src/routes/routes.php';

require '../src/config/config.php';

$app->run();