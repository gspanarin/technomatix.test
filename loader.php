<?php
include_once('vendor/autoload.php');

$loader = new Nette\Loaders\RobotLoader;
$loader->addDirectory(__DIR__ . '/app');
$loader->addDirectory(__DIR__ . '/transport');
$loader->setTempDirectory(__DIR__ . '/temp');
$loader->register(); // запустити RobotLoader

