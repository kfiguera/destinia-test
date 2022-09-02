#!/usr/bin/php
<?php

if (php_sapi_name() !== 'cli') {
    exit;
}

require __DIR__ . '/vendor/autoload.php';


use SimpleCli\SimpleCli;
use SimpleCli\Command\Call;

$app = new SimpleCli();
$app->setSignature("php index.php search default [ name=name ]");

$app->registerCommand("help", function(Call $call) use ($app) {
    $app->printSignature();
    //print_r($call->params);
});
$app->runCommand($argv);