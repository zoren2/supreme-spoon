<?php
include('helpers.php');

$data = file_get_contents('https://www.reddit.com/r/funny.json');
$data = json_decode($data, true);
write_header();
write_banner();
write_sections($data);
write_footer();

?>