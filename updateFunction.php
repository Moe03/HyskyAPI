<?php
function update($firstPage, $lastPage, $order){
    ini_set('display_errors', 0);



if(!isset($_GET['key'])){
    exit('You are not authorized.');
}
if($_GET['key'] != '2k2R5U9Ce*T4=jTZ'){
    exit('You are not authorized.');
}

require("composer/vendor/autoload.php");
include("includes/functions.php");

$key = "b90c1c23-2007-48ec-b58a-e7652ee862b8";

$link = "http://api.hypixel.net/skyblock/auctions?key=" . $key; 

$highest = 0;

echo "Debug: GETTING AUCTIONS FOR" . $order . "<br>";

$auc_array = array();


for($i = $firstPage; $i <= $lastPage; $i++){

    $auclink = "http://api.hypixel.net/skyblock/auctions?key=" . $key . "&page=" . $i;

    $aucjson = file_get_contents($auclink);

    $pageaucs = json_decode($aucjson, true);

    if($pageaucs['success'] == false){
        if(count($auc_array)){
            $auc_json = json_encode($auc_array);
            if(file_put_contents("cache/" . $order . ".json", $auc_json)){
                exit("CACHE UPDATED SUCCESSFULLY. DIDN'T REACH MAXIMUM.");
            }
        }
        else{
            exit('PAGE LIMIT REACHED');
        }
    }


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

                    $hex_code = 0;
                    if(strpos($val, "color")){
                        $startcolor_code = strpos($val, "color");
             
                        $final_color = substr($val, $startcolor_code, 250);
                        $code = preg_replace('/[^0-9]/', '', $final_color);
                        $hex_code = "#" . dechex($code);
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

                    "anvils" => $Anvils,

                    "hex_code" => $hex_code,

                    "bin" => $pageaucs["auctions"][$v]["bin"]
                );

                array_push($auc_array, $bid_details);

        }

    }

    echo count($auc_array);

    $auc_json = json_encode($auc_array);

    if($auc_json){
        echo "<br> JSON ENCODED SUCCESSFULLY <br>";
    }

    if(file_put_contents("cache/" . $order . ".json", $auc_json )){
        echo "<br> CACHE UPDATED SUCCESSFULLY FOR " . $order . " <br>";
    }
    else{
        echo " <br> CACHE FAILED TO UPDATE <br>";
    }
}

?>