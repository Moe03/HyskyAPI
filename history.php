<?php

header("Access-Control-Allow-Origin: *");

$servername = "localhost";
$username = "id11192597_mlotov";
$password = "ham0100bam0100";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully <br>";

// $AuctionsArray = json_decode(file_get_contents("cache/allauctions.json"), true);

// foreach($AuctionsArray as $Auction){
//     var_dump($Auction);
// }
?>