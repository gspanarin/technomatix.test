<?php
namespace app;
include_once('loader.php');
unset($argv[0]);
foreach ($argv as $argument) {
    preg_match('/^-(.+)=(.+)$/', $argument, $matches);
    if (!empty($matches)) {
        $paramName = $matches[1];
        $paramValue = $matches[2];
        $params[$paramName] = $paramValue;
    }            
}
print("\033[2J\033[;H");

$app = new dispetcher($argv);
$app->calculate(
        (isset($params['p']) ? intval($params['p']) : 0), 
        (isset($params['b']) ? floatval($params['b']) : 0), 
        (isset($params['d']) ? floatval($params['d']) : 0), );