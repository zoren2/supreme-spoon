<?php
use Zoren\SupremeSpoon\RedditAPI;
use Zoren\SupremeSpoon\TemplateRenderer;
use Zoren\SupremeSpoon\RegExp;
use Zoren\SupremeSpoon\DBHelper;
use Zoren\SupremeSpoon\Config;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

require(__DIR__ . '/vendor/autoload.php');

$config = new Config();
date_default_timezone_set($config->get('timezone'));
error_reporting($config->get('error_reporting'));
ini_set('display_errors', $config->get('display_errors'));

// Instantiate template and helper classes
$api      = new RedditAPI();
$dbhelper = new DBHelper($config);
$template = new TemplateRenderer(new RegExp());
$log = new Logger('Supreme-Spoon');
$log->pushHandler(new StreamHandler('logs/supremespoon.log'), Logger::INFO);
$log->pushHandler(new StreamHandler('logs/supremespoon.log'), Logger::WARNING);
$log->pushHandler(new StreamHandler('logs/supremespoon.log'), Logger::ERROR);

$dbhelper->setLogger($log);
