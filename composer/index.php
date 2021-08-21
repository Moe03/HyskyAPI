<?php
require("vendor/autoload.php");
$d = "H4sIAAAAAAAAABWOzQqCQBSFj9qPDkG7oJ2PkuiIixqh3MeUNx2wMZwb1BP1Hj1YpGd3DoePTwARPCMAeD58U3u9h3naPy3vBALWTYQZ2WuLKQGiwtSUd7pxY/0JLGvjHp1+j699P1A4cbD6fm7fT5eWh0OpQsyUvhO24yhHkLZMdXzsmcnGeUeuhcBavnjQCfNgLk8mF04q2EiVFomqZHY+llUl1Tnfy1MB+Fhk+q4bmqT+z1N2TcMAAAA=";
$nbtString = gzdecode(base64_decode($d));

$nbtService = new \Nbt\Service(new \Nbt\DataHandler());
$tree = $nbtService->readString($nbtString);
$val = strtolower(print_r($tree, true));


$start = strpos($val, "count");
$finalRaw = substr($val, $start, 100);
$finalRaw = preg_replace('/[^0-9]/', '', $finalRaw);
echo $finalRaw;

$nbtService->writeFile('test.nbt', $tree);


?>