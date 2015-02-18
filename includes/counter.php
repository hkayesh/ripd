<?php

include_once 'MiscFunctions.php';
$count_my_page = ("includes/hitcounter.inc");
$hits = file($count_my_page);
$hits[0]++;
$fp = fopen($count_my_page, "w");
fputs($fp, "$hits[0]");
fclose($fp);

$visitor = english2bangla($hits[0]);
echo $visitor;
?>