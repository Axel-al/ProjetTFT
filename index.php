<?php
require_once('Helpers/Psr4AutoloaderClass.php');

$loader = (new \Helpers\Psr4AutoloaderClass())->register();
$loader->addNamespace('Helpers', '/Helpers');
$loader->addNamespace('League\Plates', '/Vendor/Plates/src');
$loader->addNamespace('Controllers', '/Controllers');
$loader->addNamespace('Config', '/Config');

$constructor = new \Controllers\MainController(new \League\Plates\Engine('./Views/'));
$constructor->index();


?>