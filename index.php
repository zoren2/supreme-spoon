<?php
use Zoren\SupremeSpoon\RedditAPI;
use Zoren\SupremeSpoon\TemplateRenderer;
use Zoren\SupremeSpoon\RegExp;
use Zoren\SupremeSpoon\DBHelper;
use Zoren\SupremeSpoon\Config;

date_default_timezone_set('UTC');

require(__DIR__ . '/vendor/autoload.php');

// Instantiate template and helper classes
$api      = new RedditAPI();
$config   = new Config();
$dbhelper = new DBHelper($config);
$template = new TemplateRenderer(new RegExp());

$mostrecentpost = $dbhelper->fetchMostRecent($config->get('subreddit'));

try {
    if (!$data || (time() - strtotime($mostrecentpost)) > 600) {
        $data = $api->fetchPosts($config->get('subreddit'));
        $dbhelper->updatePosts($config->get('subreddit'), $data);
    }
    $data = $dbhelper->fetchPosts($config->get('subreddit'), 20);
    $template->render($data);
} catch (PDOException $errormessage) {
    $template->renderError($errormessage);
}
