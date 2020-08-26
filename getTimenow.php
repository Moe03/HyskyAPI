<?php

header("Access-Control-Allow-Origin: *");
$now = strtotime("now") * 1000;
echo json_encode($now);
?>