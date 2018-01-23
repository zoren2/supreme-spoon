<?php

include('src/Zoren/SupremeSpoon/RedditAPI.php');
include('src/Zoren/SupremeSpoon/TemplateRenderer.php');
include('src/Zoren/SupremeSpoon/RegExp.php');
use Zoren\SupremeSpoon\RedditAPI;
use Zoren\SupremeSpoon\TemplateRenderer;
use Zoren\SupremeSpoon\RegExp;

$api = new RedditAPI();
$data = $api->fetchPosts('funny');
$template = new TemplateRenderer(new RegExp());
$template->render($data);

?>
