<?php

// function display_auctions($auctions, $page){

//     $key = "09828659-42c5-4360-9203-d93bcb5df79d";

//     $aucperpage = 20;

//     $numofpages = floor(sizeof($auctions) / $aucperpage);

//     $startid = ($page - 1) * $aucperpage;

//     $endid = $startid + $aucperpage;

//     $auctionsNUM = $startid;

//     echo "<div class='row mt-5'>";


//     for($i = $startid; $i < $endid; $i++){

//         // The following if statements is to fix the auction dupliactes bugs, the point of it is that it's impossible for someone to start 2 auctions at the same exact millisecond!
//         // This was made because the skyblock api doesn't have something like "auctionID" where we can avoid duplicates easier with that.

//         if($auctions[$i]["start"] != $auctions[$i + 1]["start"] && $auctions[$i]["uuid"]!= $auctions[$i + 1]["uuid"]){
        
//                 if(isset($auctions[$i]["endingtime"])){
//                     $altEndingIn = $auctions[$i]["endingtime"];
//                 }

//                 $item = $auctions[$i]["item_name"];

//                 $itemBytes = $auctions[$i]["item_bytes"];

//                 $s_bid = $auctions[$i]["starting_bid"];

//                 $h_bid = $auctions[$i]["highest_bid_amount"];

//                 $category = $auctions[$i]["category"];

//                 $bids = $auctions[$i]["bids"];

//                 $bid_number = sizeof($bids);

//                 $uuid = $auctions[$i]['uuid'];

//                 $tier = $auctions[$i]["tier"];
                
//                 $sellerUUID = $auctions[$i]["auctioneer"];
                
//                 if(isset($auctions[$i]["sellerName"])){

//                     $seller = $auctions[$i]["sellerName"];

//                 }
//                 else{

//                     $seller = uuid_to_username($sellerUUID, $key);

//                 }

//                 # Get Top Bidder display name

//                 $bidderUUID = end($bids)['bidder'];

//                 if($bidderUUID != null)

//                 {

//                     $top_bidder = uuid_to_username($bidderUUID, $key);

//                 }

//                 else

//                 {

//                     $top_bidder = "No bids yet!";

//                 }

                

//                 // Rarity

//                 $rarity_color = '000000';

//                 if($tier == 'COMMON')

//                 {

//                     $rarity_color = '000000';

//                 }

//                 if($tier == 'UNCOMMON')

//                 {

//                     $rarity_color = '00ff00';

//                 }

//                 if($tier == 'RARE')

//                 {

//                     $rarity_color = '000958';

//                 }

//                 if($tier == 'EPIC')

//                 {

//                     $rarity_color = 'e229ff';

//                 }

//                 if($tier == 'LEGENDARY')

//                 {

//                     $rarity_color = 'ffcc00';

//                 }

                

//                 $start = $auctions[$i]["start"];

//                 $end = $auctions[$i]["end"];

                

//                 $topBidTime = end($bids)['timestamp'];

                

//                 $category_f = 'Category: ';

//                 if($category=='weapon')

//                 {

//                     $category_f = $category_f . 'Weapons';

//                 }

//                 else if($category=='armor')

//                 {

//                     $category_f = $category_f . 'Armor';

//                 }

//                 else if($category=='misc')

//                 {

//                     $category_f = $category_f . 'Miscellaneous';

//                 }

//                 else if($category=='accessories')

//                 {

//                     $category_f = $category_f . 'Accessories';

//                 }

//                 else if($category=='blocks')

//                 {

//                     $category_f = $category_f . 'Blocks';

//                 }

//                 else if($category=='consumables')

//                 {

//                     $category_f = $category_f . 'Consumables';

//                 }

//                 else

//                 {

//                     $category_f = $category_f . 'Unsorted';

//                 }

                

//                 $lore = $auctions[$i]['item_lore'];

//                 // Basically _q_ is a speacial character that will be removed, its just there to not messup the enchants numbers.

//                 $bold_removed = str_replace('§l','', $lore);
//                 $bold_removed = str_replace(" VI", " _q_VI (6)", $bold_removed);
//                 $bold_removed = str_replace(" VI,", " _q_VI (6)", $bold_removed);
//                 $bold_removed = str_replace(" V", " _q_V (5)", $bold_removed);
//                 $bold_removed = str_replace(" V,", " _q_V (5)", $bold_removed);
//                 $bold_removed = str_replace(" IV", " _q_IV (4)", $bold_removed);
//                 $bold_removed = str_replace(" IV,", " _q_IV (4)", $bold_removed);
//                 $bold_removed = str_replace(" III", " _q_III (3)", $bold_removed);
//                 $bold_removed = str_replace(" III,", " _q_III (3)", $bold_removed);
//                 $bold_removed = str_replace(" II", " _q_II (2)", $bold_removed);
//                 $bold_removed = str_replace(" II,", " _q_II (2)", $bold_removed);
//                 $bold_removed = str_replace(" I", " _q_I (1)", $bold_removed);
//                 $bold_removed = str_replace(" I,", " _q_I (1)", $bold_removed);

//                 // removing the special char (_q_)
                
//                 $bold_removed = str_replace("_q_", "", $bold_removed);

                

//                 $split_lore = explode('§',$bold_removed);

//                 $lore_colored = '';

//                 foreach ($split_lore as $lore_part)

//                 {

//                     $modifier = substr($lore_part,0,1);

//                     $rest_of_string = substr($lore_part,1);

//                     # get color from modifier

//                     $color_hex = 'ffffff';

//                     if(strlen($rest_of_string) > 1)

//                     {

//                         if($modifier == '7')

//                         {

//                             $color_hex = 'dddddd';

//                         }

//                         if($modifier == 'c')

//                         {

//                             $color_hex = 'ff0000';

//                         }

//                         if($modifier == '6')

//                         {

//                             $color_hex = 'ffcc00';

//                         }

//                         if($modifier == 'e')

//                         {

//                             $color_hex = 'ffff00';

//                         }

//                         if($modifier == 'a')

//                         {

//                             $color_hex = '00ff00';

//                         }

//                         if($modifier == '8')

//                         {

//                             $color_hex = '777777';

//                         }

//                         if($modifier == '9')

//                         {

//                             $color_hex = '6666ff';

//                         }

//                         if($modifier == 'f')

//                         {

//                             $color_hex = 'ffffff';

//                         }

//                         if($modifier == '5')

//                         {

//                             $color_hex = 'ff00ff';

//                         }

//                         $tag_str = '<span style="color:#'.$color_hex.'">'.$rest_of_string.'<br></span>';

//                         $lore_colored = $lore_colored . $tag_str;

//                     }

//                 }

//                 // Basically to avoid any confusions I'm getting here the "ending in" varablie and the "last bid was ... ago" variable
                
//                 // START TIME IS THERE FOR DEBUGGIN PURPOSES ONLY.
//                 $start_time = date_create(date('Y-m-d H:i:s',$start/1000));

//                 $end_time = date_create(date('Y-m-d H:i:s', $end/1000));

//                 $cur_time = date_create(date('Y-m-d H:i:s'));

//                 $last_time = date_create(date('Y-m-d H:i:s',$topBidTime/1000));

                
//                 $end_diff = date_diff($end_time,$cur_time);

//                 $last_diff = date_diff($last_time,$cur_time);
                

//                 # Auction Template.

//                 $key = "09828659-42c5-4360-9203-d93bcb5df79d";

//                 $sellerArray = json_decode(file_get_contents("https://api.hypixel.net/player?key=" . $key  . "&name=" . $seller), true);

//                 $sellerRank = " " . strtoupper($sellerArray["player"]["newPackageRank"]);

//                     $sellerRank = str_replace("_PLUS", "+", $sellerRank);

//                     if(strpos($sellerRank, "VIP")){
//                         $sellerColor = "#66CD00";
//                     }
//                     elseif(strpos($sellerRank, "MVP")){
//                         $sellerColor = "#00D5FF";
//                     }
//                     else{
//                         $sellerColor = "#c9c9c9";
//                     }

//                     $sellerRank = trim($sellerRank);

//                     if(!isset($seller)){
//                         $sellerp = "UNKNOWN";
//                         $seller = "UNKNOWN Copy UUID Below";
//                     }
                    
//                     if(!isset($sellerRank) || $sellerRank == NULL || $sellerRank == ""){
//                         $sellerRank = "None";
//                     }

                    

//                 echo "<div class='col-12 col-lg-6'>
//                 <div class='auction d-flex col-12 flex-column flex-lg-row' style='margin-bottom:50px;'>
                
//                     <div class='d-flex justify-content-center'>
//                         <div class='left-auc-side d-flex flex-column align-items-center mx-3 py-2' style='width: 120px'>

//                             <div class='mb-3'>
//                                 <img src='https://minotar.net/armor/body/" .$seller. "/100.png'>
//                             </div>

//                             <div class='mb-3'>
//                                 <p class='mb-1 text-center'><strong>".$seller . "</strong></p>" . "<p class='mb-1 text-center'><span style='color: $sellerColor;'>[" .$sellerRank . "]</span></p>
//                             </div>

//                             <div>
//                                 <button onclick=\"copy('/ah '+'"; if($seller == "UNKNOWN Copy UUID Below"){ echo $sellerUUID; } else{ echo $seller; } echo "')\">COPY</button>
//                             </div>

//                         </div>
//                     </div>
                
//                     <div class='right-auc-side d-flex flex-column' style='width: 100%;'>

//                         <div class='ml-0 ml-lg-3 mt-3 mt-lg-0' style='width: 100%;'>";

//                             $auctionsNUM += 1;
    
//                             echo "<div><p style='font-size: 25px;' class='text-center'># " . $auctionsNUM . "</p></div>";
                            
//                             echo "<div><p style='color:#$rarity_color !important; font-size: 19px;' class='text-center'><strong>" . $item . "</strong></p></div>

//                             <div><p class='text-center' style=\"font-size:12px; color: #c9c9c9;\">".$category_f."</p></div>";

//                             if(format_interval($end_diff)){

//                                 if( date('Y-m-d H:i:s',$end/1000) < date('Y-m-d H:i:s') ){

//                                     echo "<p class='text-center mt-3' style=\"font-size:13px\">Ended</p> <p class='text-center'><strong><span class='text-danger'> " . format_interval($end_diff) . " ago</span></strong></p>";
//                                 }

//                                 else{

//                                     echo "<p class='text-center mt-3' style=\"font-size:13px\">Ending in</p> <p class='text-center'><strong>" . format_interval($end_diff) . "</strong></p>";

//                                 }
//                             }
//                             else{

//                                 echo $altEndingIn . " Minutes <br>";

//                                 echo "Auction started exactly at: ". $start_time . "<br>";

//                                 echo "Auction ending exactly at: " . $end_time . "<br>";

//                             }

//                             echo "<div class='d-flex justify-content-center my-2'><button class='showlore' onclick=\"showLore        ('".$uuid."')\" id=\"btn-".$uuid."\"'>DETAILS</button></div>

//                                 <div id=\"block-".$uuid."\" style=\"display:none\">

//                                 <div class='d-flex justify-content-center my-2'><button onclick=\"hideLore('".$uuid."')\">Hide</button></div>

//                                     <hr>

//                                     <p style='font-size:11px;width:auto;padding:5px;background:black'>".$lore_colored."</p>

//                                     <hr>

//                             </div>";

//                             echo "</strong><br></p>

//                             <div class='d-flex justify-content-around'>
//                                 <div class='text-center'>
//                                     <p style=\"margin-bottom: 5px;\"><strong>Start Bid</strong></p>". "<p class='text-center'><strong>" . number_format_short($s_bid) ."</strong></p>
//                                 </div>

//                                 <div class='text-center'>
//                                     <p style=\"margin-bottom: 5px;\"><strong>Top Bid</strong></p>". "<p class='text-center'><strong>" . number_format_short($h_bid)."</strong></p>
//                                 </div>";

//                             echo "</div>";

//                             echo "<br><span style=\"font-size:12px;\">Top Bid By: ".$top_bidder." - ";
                                
//                             if(sizeof($bids))
//                             {echo small_format_interval($last_diff) . " Ago.";
//                             }
//                             else
//                             {
//                             echo "Be The First Bidder!";
//                             }
//                             ;

//                             echo "</span><br><small style='font-size: 12px;'>This item has ".$bid_number." bid(s).</small>
                            
//                         </div>

//                     </div>

//                 </div>

//             </div>
//             ";

//         }

//     else
    
//     {

//         $skippedID = true;

//     }
// }

//     echo "<div class='row'>";
// }


// function uuid_to_username($uuid, $key){

//     $NameLink = "https://api.mojang.com/user/profiles/" . $uuid  . "/names";
     
//     $NameFile = file_get_contents($NameLink);

//     $NameJson = json_decode($NameFile,true);
    
//     return end($NameJson)["name"];

// }

// function _checkTime($filetime,$time = 10) // $time value is in minutes, the default is 3 minutes

// {

// $t = time() - $filetime;

// if($t/60>$time)

//     {

//         return true;

//     }

// else

//     {

//         return false;

//     }

// }



// function format_interval(DateInterval $interval) {

// $result = "";

// if ($interval->y) { $result .= $interval->format("%y Y "); }

// if ($interval->m) { $result .= $interval->format("%m Months "); }

// if ($interval->d) { $result .= $interval->format("%d Days "); }

// if ($interval->h) { $result .= $interval->format("%h Hours "); }

// if ($interval->i) { $result .= $interval->format("%i Min "); }

// if ($interval->s) { $result .= $interval->format("%s Sec "); }



// return $result;

// }

// function small_format_interval(DateInterval $interval) {

//     $result = "";
    
//     if ($interval->y) { $result .= $interval->format("%y years "); return $result; }
    
//     if ($interval->m) { $result .= $interval->format("%m months "); return $result; }
    
//     if ($interval->d) { $result .= $interval->format("%d days "); return $result; }
    
//     if ($interval->h) { $result .= $interval->format("%h hours "); return $result; }
    
//     if ($interval->i) { $result .= $interval->format("%i minutes "); return $result; }
    
//     if ($interval->s) { $result .= $interval->format("%s seconds "); return $result; }
    
//     }

function to_minutes(DateInterval $interval) {

    $result;
    
    if ($interval->y) { 
        $interval->y = $interval->y * 525600;
    }
    
    if ($interval->m) { 
        $interval->m = $interval->m * 43830;
    }
    
    if ($interval->d) { 
        $interval->d = $interval->d * 1440;
    }
    
    if ($interval->h) {
         $interval->h = $interval->h * 60;
    }
    
    if ($interval->i) {
         $interval->i = $interval->i;
    }
    
    if ($interval->s) {
        $interval->s = $interval->s * 0.01666667; 
    }

    $result = $interval->y + $interval->m + $interval->d + $interval->h + $interval->i + $interval->s;
    return $result;
}



function pagination($pageo, $numofpagess, $link){

if($pageo > $numofpagess || $pageo <= 0){
die("This Page Doesn't exsist.");
}

echo "<ul class='pagination justify-content-center'>";

echo "<li class='page-item active'><a class='page-link' href='/$link" . "page=1'> << </a></li>";

for($u = $pageo - 1; $u <= $pageo + 3 && $u <= $numofpagess; $u++){

if($u == 0){

    echo ""; 

}

elseif($u == $pageo){

    echo "<li class='page-item active'><a class='page-link' href='/$link" . "page=" . $u . "'>" . $u ."</a></li>"; 

}

else{

    echo "<li class='page-item'><a class='page-link' href='/$link" . "page=" . $u . "'>" . $u ."</a></li>";

}

}

echo "<li class='page-item active'><a class='page-link' href='/$link" . "page=" . $numofpagess . "'> >> </a></li>";

echo "</ul>";

}


// Converts a number into a short version, eg: 1000 -> 1k
// Thank you -> http://stackoverflow.com/a/4371114 For This Neat Function :)
function number_format_short( $n, $precision = 1 ) {
	if ($n < 900) {
		// 0 - 900
		$n_format = number_format($n, $precision);
		$suffix = '';
	} else if ($n < 900000) {
		// 0.9k-850k
		$n_format = number_format($n / 1000, $precision);
		$suffix = 'K';
	} else if ($n < 900000000) {
		// 0.9m-850m
		$n_format = number_format($n / 1000000, $precision);
		$suffix = 'M';
	} else if ($n < 900000000000) {
		// 0.9b-850b
		$n_format = number_format($n / 1000000000, $precision);
		$suffix = 'B';
	} else {
		// 0.9t+
		$n_format = number_format($n / 1000000000000, $precision);
		$suffix = 'T';
	}
  // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
  // Intentionally does not affect partials, eg "1.50" -> "1.50"
	if ( $precision > 0 ) {
		$dotzero = '.' . str_repeat( '0', $precision );
		$n_format = str_replace( $dotzero, '', $n_format );
	}
	return $n_format . $suffix;
}




?>