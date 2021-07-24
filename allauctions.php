<?php

ini_set('display_errors', 0);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if(!isset($_GET['key'])){
    exit('You are not authorized.');
}
if($_GET['key'] != 'jTZ'{
    exit('You are not authorized.');
}

ini_set('memory_limit', '8192M');
ini_set('max_execution_time', 50000);
require("composer/vendor/autoload.php");
include("includes/functions.php");

$key = "YOUR KEY";

$link = "http://api.hypixel.net/skyblock/auctions?key=" . $key; 

$highest = 0;

echo "Debug: Thanks for calling the cache :)";

$auc_array = array();

$json = file_get_contents($link);

$auctions = json_decode($json, true);

$total_auctions = $auctions["totalAuctions"];

$auctions_real_pages = $auctions["totalPages"];


for($i = 1; $i < $auctions_real_pages; $i++){

    $auclink = "http://api.hypixel.net/skyblock/auctions?key=" . $key . "&page=" . $i;

    $aucjson = file_get_contents($auclink);

    $pageaucs = json_decode($aucjson, true);


    for($v = 0; $v < 1000; $v++){

                    $end = $pageaucs["auctions"][$v]["end"];

                    $now = strtotime("now") * 1000;
                    
                    $endingTimeMilli = $end - $now;

                    $endingTimeMinutes = ($endingTimeMilli / 1000) / 60;

                    $endingTime = $endingTimeMinutes;

                    $itemBytes = $pageaucs["auctions"][$v]["item_bytes"];

                    $d = $itemBytes;

                    // Extracting Item Count from the item bytes.

                    $nbtString = gzdecode(base64_decode($d));
                    $nbtService = new \Nbt\Service(new \Nbt\DataHandler());
                    $tree = $nbtService->readString($nbtString);
                    $val = strtolower(print_r($tree, true));
                    $startCount = strpos($val, "count");
                    $finalCount = substr($val, $startCount, 100);
                    $itemCount = preg_replace('/[^0-9]/', '', $finalCount);

                    $Anvils = "No Anvil Uses";
                    if(strpos($val, "anvil_uses")){
                        $startAnvils = strpos($val, "anvil_uses");
             
                        $finalAnvils = substr($val, $startAnvils, 250);
                        $Anvils = str_replace("1", "" , preg_replace('/[^0-9]/', '', $finalAnvils));
                    }
                    

                    if($pageaucs["auctions"][$v]["starting_bid"] >= $pageaucs["auctions"][$v]["highest_bid_amount"]){

                        $highest = $pageaucs["auctions"][$v]["starting_bid"];

                    }

                    else{

                        $highest = $pageaucs["auctions"][$v]["highest_bid_amount"];

                    }
                

                $bid_details = array(

                    "item_name" => $pageaucs["auctions"][$v]["item_name"],

                    "starting_bid" => $pageaucs["auctions"][$v]["starting_bid"],

                    "highest_bid_amount" => $pageaucs["auctions"][$v]["highest_bid_amount"],

                    "category" => $pageaucs["auctions"][$v]["category"],

                    "bid_num" => sizeof($pageaucs["auctions"][$v]["bids"]),

                    "latest_bid" => end($pageaucs["auctions"][$v]["bids"]),

                    "tier" => $pageaucs["auctions"][$v]["tier"],

                    "end" => $pageaucs["auctions"][$v]["end"],

                    "highest" => $highest,

                    "auctioneer" => $pageaucs["auctions"][$v]["auctioneer"],

                    "item_lore" => $pageaucs["auctions"][$v]["item_lore"],

                    "uuid" => $pageaucs["auctions"][$v]["uuid"],

                    "endingtime" => $endingTime,

                    "item_count" => $itemCount,

                    "anvils" => $Anvils
                );

                array_push($auc_array, $bid_details);

        }

    }

    $auc_json = json_encode($auc_array);

    if($auc_json){
        echo "<br> JSON ENCODED SUCCESSFULLY <br>";
    }

    if(file_put_contents("cache/allauctions.json", $auc_json )){
        echo "CACHE UPDATED SUCCESSFULLY <br>";
    }
    else{
        echo "CACHE FAILED TO UPDATE <br>";
    }

    // if(require_once("history.php")){
    //     echo "PASSED TO HISTORY SUCCESSFULLY";
    // }

?>
