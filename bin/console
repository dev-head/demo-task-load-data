<?php

/**
 * Some typical php.ini setting overrides for our application experience.
 */
ini_set('memory_limit', '-1');
ini_set('display_errors', true);
ini_set('error_reporting', E_ALL);
ini_set('log_errors', true);
ini_set('date.timezone', 'America/Los_Angeles');
set_time_limit(0);

$script_dir = dirname(__DIR__);
$app_dir    = dirname(Phar::running(false));
$app_dir    = $app_dir? $app_dir : $script_dir;
require_once $script_dir . '/vendor/autoload.php';

$app_name       = 'dapi';   // @todo expose via config.
$app_version    = '0.0.1';  // @todo pull from git tag | config.
$app = new \dapi\Application($app_name, $app_version);
$app->command(new \dapi\Command\LoadDataCommand());
$app->run();