<?php
include('bootstrap.php');

$mostrecentpost = $dbhelper->fetchMostRecent($config->get('subreddit')); // Retrieves most recent post to see how much time has elapsed

try {
    if (!$data || (time() - strtotime($mostrecentpost)) > 600) {
        $data = $api->fetchPosts($config->get('subreddit'));
        $dbhelper->updatePosts($config->get('subreddit'), $data);
    }
    $data = $dbhelper->fetchPosts($config->get('subreddit'), 20);
    $template->render($data);
} catch (PDOException $errormessage) {
    $template->renderError($errormessage);
    $log->error($errormesssage);
}
