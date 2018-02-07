<?php
include('bootstrap.php');

$mostrecentpost = $dbhelper->fetchMostRecent($_GET['subreddit']); // Retrieves most recent post to see how much time has elapsed

try {
    if (!$data || (time() - strtotime($mostrecentpost)) > 600) {
        $data = $api->fetchPosts($_GET['subreddit']);
        $dbhelper->updatePosts($_GET['subreddit'], $data);
    }
    $data = $dbhelper->fetchPosts($_GET['subreddit'], 20);
    $template->renderSections($data);
} catch (PDOException $errormessage) {
    $template->renderError($errormessage);
    $log->error($errormesssage);
}
