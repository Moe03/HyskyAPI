<?php

header("Access-Control-Allow-Origin: *");

ini_set('display_errors', 0);

session_start();

if(isset($_GET["q"])){

    $l = trim(strtolower($_GET["q"]));

    // Smart Search:
    include("includes/smart_search.php");

}

else{

    die("No search queries found please try again.");

}

$_GET["q"] = $l;

$search_query = trim(strtolower($_GET["q"]));

$search_array = explode(" ", $search_query);

$customLink = str_replace(" ", "+", $search_query);

$search_query = str_replace(" ", "", $search_query);

$pageLink = "search?q=" . $customLink . "&";


?>


<?php
// ini_set('display_errors', 1);

// ini_set('display_startup_errors', 1);

// error_reporting(E_ALL);

ini_set('memory_limit', '8192M');

ini_set('allow_url_fopen', 'On');

include("includes/functions.php");

require_once("includes/header.php");

$_SESSION["title"] = "HySky | Auction Search";

$ah = true;

?>

<script src="/js/auction-page-handler.js"></script>

<link rel="stylesheet" type="text/css" href="/styles/auction-display.css"/>

<?php

            if( sizeOf(unserialize(file_get_contents("cache/allauctions.json"))) <= 1 || _checkTime(filemtime("cache/allauctions.json")) ){
            echo "<script>console.log('CACHE NOT LOADED CALLED API')</script>";

            $key = "09828659-42c5-4360-9203-d93bcb5df79d";

            $link = "https://api.hypixel.net/skyblock/auctions?key=" . $key; 

            $highest = 0;

            $_SESSION["search_bids"] = array();

            $json = file_get_contents($link);

            $auctions = json_decode($json, true);

            $total_auctions = $auctions["totalAuctions"];

            $auctions_real_pages = $auctions["totalPages"];

            $auctions_cache = array(); 

            // Getting all auctions with that search term

            for($i = 0; $i < $auctions_real_pages; $i++){

                $auclink = "https://api.hypixel.net/skyblock/auctions?key=" . $key . "&page=" . $i;

                $aucjson = file_get_contents($auclink);

                $pageaucs = json_decode($aucjson, true);


                for($v = 0; $v < 1000; $v++){

                        // Caching all the search results in case user makes another query.

                            $end = $pageaucs["auctions"][$v]["end"];

                            $start = $pageaucs["auctions"][$v]["start"];

                            $end_time = new DateTime(date('Y-m-d H:i:s',$end/1000));

                            $cur_time = new DateTime(date('Y-m-d H:i:s'));

                            $end_diff = date_diff($cur_time,$end_time);

                            $endingTime = to_minutes($end_diff);

                            if($pageaucs["auctions"][$v]["starting_bid"] >= $pageaucs["auctions"][$v]["highest_bid_amount"]){

                                $highest = $pageaucs["auctions"][$v]["starting_bid"];

                            }

                            else{

                                $highest = $pageaucs["auctions"][$v]["highest_bid_amount"];

                            }

                            $sellerName = json_decode(file_get_contents("https://api.mojang.com/user/profiles/" . $pageaucs["auctions"][$v]["uuid"] . "/names"), true);
                            
                            $sellerName = end($sellerName);

                            $auctions_cache_details = array(

                            "item_name" => $pageaucs["auctions"][$v]["item_name"],

                            "starting_bid" => $pageaucs["auctions"][$v]["starting_bid"],

                            "highest_bid_amount" => $pageaucs["auctions"][$v]["highest_bid_amount"],

                            "category" => $pageaucs["auctions"][$v]["category"],

                            "bids" => $pageaucs["auctions"][$v]["bids"],

                            "tier" => $pageaucs["auctions"][$v]["tier"],

                            "start" => $pageaucs["auctions"][$v]["start"],

                            "end" => $pageaucs["auctions"][$v]["end"],

                            "highest" => $highest,

                            "auctioneer" => $pageaucs["auctions"][$v]["auctioneer"],

                            "item_lore" => $pageaucs["auctions"][$v]["item_lore"],

                            "item_bytes" => $pageaucs["auctions"][$v]["item_bytes"],

                            "uuid" => $pageaucs["auctions"][$v]["uuid"],

                            "endingin" => $end_diff,

                            "endingtime" => $endingTime,

                            "sellerName" => $sellerName

                        );

                        array_push($auctions_cache, $auctions_cache_details);

                        // CACHE PART ENDED.

                        $item_name = trim(strtolower($pageaucs["auctions"][$v]["item_name"]));

                        $item_name = str_replace(" ", "", $item_name);

                        $item_name = " " . $item_name;

                        $item_lore = strtolower($pageaucs["auctions"][$v]["item_lore"]);

                        $num_prec = 0;

                        // DETERMINING WETHER THE SEARCH QUERY IS MORE THAN 3 WORDS.

                        if(sizeOf($search_array) > 0){

                            $trigger_precision = true;
    
                            for($z = 0; $z < sizeOf($search_array); $z++){
    
                                if(isset($search_array[$z]))
                                {
    
                                    $search_part = str_replace( " ", "", $search_array[$z]);
    
                                    $armor_array= array("helmet", "chestplate", "legging", "boot");
    
                                    if(strpos(" " . $search_part, "armor")){
                                        foreach($armor_array as $armor_piece){
                                            $e_search_part = trim(str_replace("armor", $armor_piece, $search_part));
                                            if(strpos($item_name, $e_search_part)){
                                                $num_prec += 1;
                                            }
                                        }
                                    }
    
                                    elseif(strpos($item_name, $search_part))
                                    {
    
                                        $num_prec += 1;
    
                                    }
    
                                }
                                else
                                {
    
                                    $trigger_precision = false;
    
                                }
                            }
                        }
    
                        else{
                            
                            $trigger_precision = false;
    
                            $num_prec = -1;
    
                        }
    
                        if( $num_prec >= sizeof($search_array) ){
                            

                            $bid_details = array(

                                "item_name" => $pageaucs["auctions"][$v]["item_name"],

                                "starting_bid" => $pageaucs["auctions"][$v]["starting_bid"],

                                "highest_bid_amount" => $pageaucs["auctions"][$v]["highest_bid_amount"],

                                "category" => $pageaucs["auctions"][$v]["category"],

                                "bids" => $pageaucs["auctions"][$v]["bids"],

                                "tier" => $pageaucs["auctions"][$v]["tier"],

                                "start" => $pageaucs["auctions"][$v]["start"],

                                "end" => $pageaucs["auctions"][$v]["end"],

                                "highest" => $highest,

                                "auctioneer" => $pageaucs["auctions"][$v]["auctioneer"],

                                "item_lore" => $pageaucs["auctions"][$v]["item_lore"],

                                "item_bytes" => $pageaucs["auctions"][$v]["item_bytes"],

                                "uuid" => $pageaucs["auctions"][$v]["uuid"],

                                "endingin" => $end_diff,

                                "endingtime" => $endingTime,

                                "sellerName" => $sellerName

                            );

                            array_push($_SESSION["search_bids"], $bid_details);

                    }

                }

            }

            file_put_contents("totalaucs.json", serialize($total_auctions));

            file_put_contents("cache/allauctions.json", serialize($auctions_cache));

        }

        else{

            echo "<script>console.log('CACHE LOADED :)')</script>";

            $_SESSION["search_bids"] = array();

            $allAuctions  = unserialize(file_get_contents("cache/allauctions.json"));

            $total_auctions = unserialize(file_get_contents("totalaucs.json"));
            
                for($v = 0; $v < $total_auctions; $v++){

                    $item_name = strtolower($allAuctions[$v]["item_name"]);

                    $item_name = trim(str_replace(" ", "", $item_name));

                    $item_name = " " . $item_name;

                    $num_prec = 0;

                    if(sizeOf($search_array) > 0){

                        $trigger_precision = true;

                        for($z = 0; $z < sizeOf($search_array); $z++){

                            if(isset($search_array[$z]))
                            {

                                $search_part = str_replace( " ", "", $search_array[$z]);

                                $armor_array= array("helmet", "chestplate", "legging", "boot");

                                if(strpos(" " . $search_part, "armor")){
                                    foreach($armor_array as $armor_piece){
                                        $e_search_part = trim(str_replace("armor", $armor_piece, $search_part));
                                        if(strpos($item_name, $e_search_part)){
                                            $num_prec += 1;
                                        }
                                    }
                                }

                                elseif(strpos($item_name, $search_part))
                                {

                                    $num_prec += 1;

                                }

                            }
                            else
                            {

                                $trigger_precision = false;

                            }
                        }
                    }

                    else{
                        
                        $trigger_precision = false;

                        $num_prec = -1;

                    }

                    if( $num_prec >= sizeof($search_array) ){

                        array_push($_SESSION["search_bids"], $allAuctions[$v]);

                    }   

                }
            }

?>


<div>

        <div class="container">
    <h1 style="margin-top: 15vh;" class="text-white text-center">
            Search Results (BETA)
    </h1>
    <p class="text-white text-center">
        Check out <a href='/smartinfo'>Smart Search!</a>
    </p>

<?php 

$searchResults = $_SESSION["search_bids"];

// Pagination variables:

if (isset($_GET['page'])) {

    $page = $_GET['page'];

} else {

    $page = 1;

}

$aucperpage = 20;

$numofpages = ceil(sizeof($searchResults) / $aucperpage);

$startid = ($page - 1) * $aucperpage;

$endid = $startid + $aucperpage;

// Search query returned results

if(sizeOf($searchResults))

{

    // Sorting ascendingly according to ending time of each auction in minutes.

    if(array_multisort(array_column($searchResults, 'endingtime'), SORT_ASC, $searchResults))

    {
            echo "<p style='margin-bottom: 15vh;' class='text-center text-white'>Total Auctions: " . $total_auctions . "</p>";
                
            // The search box and paginaton, feel free to put that into a function.

            echo '<div class="row">

            <div class="col-12 col-lg-4">

            <form action="/search" method="GET">
                    
            <input style="width: 75%; display: inline;" required placeholder="Search for an item" type="text" class="form-control" name="q" id="q">
                    
            <button style="display: inline-block" type="submit" class="btn btn-default"><img style="width: 30px;" src="https://image.flaticon.com/icons/svg/639/639375.svg"></button>
            </form> ';

            echo "</div>";

            echo "<div class='col-12 col-lg-4'>";

            pagination($page, $numofpages, $pageLink);

            echo "</div>";

            echo '<div class="col-12 col-lg-4">
                        <form action="/playerah" method="GET">
                            
                        <input style="width: 75%; display: inline;" required placeholder="Search for player\'s auctions" type="text" class="form-control" name="q" id="q">
                        
                        <button style="display: inline-block" type="submit" class="btn btn-default"><img style="width: 30px;" src="https://image.flaticon.com/icons/svg/639/639375.svg"></button>
                </form>
                </div>';

            echo "</div>";

            display_auctions($searchResults, $page);
                


    }
    
    else

    {

        echo "<p class='text-center m-5 text-danger'>Sorting failed please try again later.</p>";

    }

    echo "<div style='width: 100%;' class='d-flex justify-content-center'>";

    pagination($page, $numofpages, $pageLink);

    echo "</div>";

}

else

{

    echo '<div style="height: 100%;" class="row flex-column align-items-center my-5">

        <div class="col-12 col-lg-6 align-items-center justify-content-center">';

            echo "<h3 class='text-light'>No auctions found :(</h3>";

        echo "</div>";

        echo "<div class='col-12 col-lg-6 align-items-center justify-content-center mt-4'>";

                echo '<form action="/search" method="GET">
                            
                <input style="width: 80%; display: inline;" required placeholder="Search for an item" type="text" class="form-control" name="q" id="q">
                        
                <button style="display: inline-block" type="submit" class="btn btn-default"><img style="width: 30px;" src="https://image.flaticon.com/icons/svg/639/639375.svg"></button>
                </form> ';

        echo "</div>";

        echo "<div class='col-12 col-lg-6 align-items-center justify-content-center mt-4'>";

                echo '<form action="/playerah" method="GET">
                            
                <input style="width: 80%; display: inline;" required placeholder="Search for player\'s auctions" type="text" class="form-control" name="q" id="q">
                        
                <button style="display: inline-block" type="submit" class="btn btn-default"><img style="width: 30px;" src="https://image.flaticon.com/icons/svg/639/639375.svg"></button>
                </form> ';

        echo "</div>";

        echo "<div class='col-12 col-lg-6 align-items-center justify-content-center mt-4'>";

                echo '<span class="text-white">Back to</span> <a href="/ah">AH</a>';

        echo "</div>";

    echo "</div>";
}



?>

    </div>

</div>


<?php
require_once("includes/footer.php");
?>