<?php

//$dbhost = "192.168.1.100";
//$dbname = "ripd_db_comfosys";
//$dbuser = "cfs_jessy";
//$dbpass = "jesy4321";

$dbhost = '10.34.46.6';
$dbuser = 'ripduniv_cfs';
$dbpass = 'ripdcfs2013';
$dbname = 'ripduniv_comfosys';



// database connection
$conn = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass);
$conn->exec("set names utf8");
?>