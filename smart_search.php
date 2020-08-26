<?php

header("Access-Control-Allow-Origin: *");

ini_set('display_errors', 0);

$query = " " . $query;

    if(strpos($query, "aote") || strpos($query, "aoet")){
        $query = str_replace("aote", "aspectoftheend", $query);
    }

    if(strpos($query, "aotd") || strpos($query, "aodt")){
        $query = str_replace("aotd", "aspectofthedragons", $query);
    }

    if(strpos($query, "ls")){
        $query = str_replace("ls", "leapingsword", $query);
    }

    if(strpos($query, "sda")){
        $query = str_replace("sda", "superiordragon armor", $query);
    }
    if(strpos($query, "uda")){
        $query = str_replace("uda", "unstabledragon armor", $query);
    }

    if(strpos($query, "stda")){
        $query = str_replace("stda", "strongdragon armor", $query);
    }
    if(strpos($query, "pda")){
        $query = str_replace("pda", "protectordragon armor", $query);
    }
    if(strpos($query, "wda")){
        $query = str_replace("wda", "wisedragon armor", $query);
    }

    if(strpos($query, "oda")){
        $query = str_replace("oda", "olddragon armor", $query);
    }

    if(strpos($query, "yda")){
        $query = str_replace("yda", "youngdragon armor", $query);
    }

$query = trim($query);

?>