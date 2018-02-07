<?php
use Zoren\SupremeSpoon\RedditAPI;
use Zoren\SupremeSpoon\TemplateRenderer;
use Zoren\SupremeSpoon\RegExp;
use Zoren\SupremeSpoon\DBHelper;
use Zoren\SupremeSpoon\Config;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

date_default_timezone_set('UTC');

require(__DIR__ . '/vendor/autoload.php');

// Instantiate template and helper classes
$api      = new RedditAPI();
$config   = new Config();
$dbhelper = new DBHelper($config);
$template = new TemplateRenderer(new RegExp());
$log = new Logger('Supreme-Spoon');
$log->pushHandler(new StreamHandler('logs/supremespoon.log'), Logger::INFO);
$log->pushHandler(new StreamHandler('logs/supremespoon.log'), Logger::WARNING);
$log->pushHandler(new StreamHandler('logs/supremespoon.log'), Logger::ERROR);

$dbhelper->setLogger($log);
