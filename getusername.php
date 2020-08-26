<?php 

header("Access-Control-Allow-Origin: *");


// error_reporting(E_ALL);
ini_set('display_errors', 0);
// ini_set("allow_url_fopen", true);

    $id = $_GET["uuid"];
    $sellerName = end( json_decode(file_get_contents("https://api.mojang.com/user/profiles/" . $id . "/names"), true) )["name"];
    echo json_encode($sellerName);
   
    
?>