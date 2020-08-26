<?php

require("composer/vendor/autoload.php");

ini_set('display_errors', 0);

$itemBytes = $pageaucs["auctions"][$v]["item_bytes"];

                    $d = "H4sIAAAAAAAAAFVUXW4iRxAu/LMGdpWNEidS/jvRWrLltRcwBuMoDxgwRsZgAcsqT6NmKKBFTzeZ7nHsC+QKOYLv4aPkIFGqZ4Z4lxemvvqquqr6q84D5CAj8gCQ2YANMc3sZmC7oSNlM3nYtHyegy1U/gLcLwMv36tJiHzJJxIzm5C7ElO8lHxuyPtvHnamwqwkf6Cgrg4xS+j38N3TY7XJAz7Hc/b06B+Wyqf0j/uHpcIBHJJzaENUc7tI3MXSs5s+zvaHK+E/sMPTA9gjciMUljUWXPlpuuLex6zi3gHsr2kfn1osFD4hnhZSZt1a7i/ZcIU4XVM/TemYAN8+PdYaEvkdsvFb5gw6QvhcsjH86MxoIkyQ+lpqiiEb0ijobww/Oege/ciug1v3KwwFTRZZp9NxndUuRYisblboW8JiFkHGMpqPWBJvDL8Q1hZcWXYtpHSpY1onWHEp1DxO9TMBXbQLQuxDSuiKGVIapGId5RsHaW3TkIQS0RDG4D6HPjWp5pR+7RwueLhSaAxLahihxKUgQBiWMEaLyLUsdTglzg+EjHmwEuHzSMaodKAjlwLgK5rzP3//xS6k1lM2iFQyhi9p7AP8I6JJGCbxDiUrEvv46bHSsRiw+kS4rs5ZM+RzrdiArteJ5elRDjrtqxFrdDuNazfual1KdqOVsRgaJhSbhZrGpmfsQUcxwfKli+XFt4XTAtlsGqvlmF0J64ZYDdbRMVPykM5aKu0vJ6SXY9ilWm+44qyhjXXCOSGJwReENrSWU/2nciA/NUm7Faqx22q3es364Hc2/NAfNLOw1eMBOvVUEq2lt09V2gWmTRrIw+vWvQ05KTUUE9KQ2YTPF9p6K2251Z7v1pVOyedhO6RRknvnotvvN70SoZuQhc+IfRuTL7SKDHw9HA1avfbo6rdS4ddm/abebrmvLGQDPRUzgSFsG1dRFnI6FHOhRnwOO+97173+h17WPRSwWx/ethojr3/pja5aXnNQb/d7eXjlXgtSaIDKUiFZkWrTVbIJW5JkRp/b5PHT/UnMF368W4mxIxN1JkE5sxZkYtMRJDXPxNuVBLy0z4p0DxUhMxKRx+OBErJBae7Wikxi8vj/DiZ5dzBZ0dQtaWk845YmPXbuNs9bxpuX9nCXijoxX83cvlKM21eCtlxhz4uRkHJmvUzrxuOHI3XK9eY6m25uK4po1m+4f1aplmvloxMfq0dlPCkc1Sp++QhL/uykys9qlbMalczVnZBeZNDlfk2XZ0WAxlLf8PrsXbH0rlhjpfNyid3e0EjgRfJAuqf9P087258JBgAA";

                    // Extracting Item Count from the item bytes.

                    $nbtString = gzdecode(base64_decode($d));
                    $nbtService = new \Nbt\Service(new \Nbt\DataHandler());
                    $tree = $nbtService->readString($nbtString);
                    $val = strtolower(print_r($tree, true));

                 
                    
                    $Anvils = "No Anvil Uses";
                    if(strpos($val, "anvil_uses")){
                        $startAnvils = strpos($val, "anvil_uses");
             
                        $finalAnvils = substr($val, $startAnvils, 250);
                        $Anvils = preg_replace('/[^0-9]/', '', $finalAnvils);
                    }
                    echo str_replace("1","",$Anvils);

                    

?>