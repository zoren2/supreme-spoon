<?php
use Zoren\SupremeSpoon\RedditAPI;
use Zoren\SupremeSpoon\TemplateRenderer;
use Zoren\SupremeSpoon\RegExp;
use Zoren\SupremeSpoon\DBHelper;
use Zoren\SupremeSpoon\Config;

date_default_timezone_set('UTC');

/* 
 * The autoload function is called when you try to initialize a class which
 * does not exist. It's the responsbility of the autoloader to find the file
 * where the class is defined, and include it.
 */
spl_autoload_register(function($class_name) {
    // Converts class names eg:'Zoren\SupremeSpoon\RegExp' to a file path like 'Zoren/SupremeSpoon/RegExp'.
    $file_name = str_replace("\\", "/", $class_name);
    
    // Include the class file from the 'src/' directory.
    include(__DIR__ . "/src/${file_name}.php");
});

// Instantiate template and helper classes
$api = new RedditAPI();
$config = new Config();
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
