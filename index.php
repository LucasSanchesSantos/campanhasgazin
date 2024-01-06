<?php

use App\App;
use App\Lib\Erro;

error_reporting(E_ALL & ~E_NOTICE);

require_once("vendor/autoload.php");

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    
    $app = new App();
    $app->run();
} catch (\Exception $e) {
    $oError = new Erro($e);
    $oError->render();
}
