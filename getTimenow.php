<?php
header("Access-Control-Allow-Origin: *");

ini_set('display_errors', 0);

header("Access-Control-Allow-Origin: *");
$now = strtotime("now") * 1000;
echo json_encode($now);
?>