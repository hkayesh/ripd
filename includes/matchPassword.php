<?php
error_reporting(0);
session_start();
include_once 'ConnectDB.inc';
 $p_user_name = $_SESSION['UserID'];
 //echo 'Account: '.$p_acc;
 $p_pass = md5($_GET['pass']);

$cfs_query = mysql_query("SELECT * FROM cfs_user WHERE user_name= '$p_user_name' AND password='$p_pass';");
$y = mysql_num_rows($cfs_query);
if($y <= 0)
{
    //echo "1";
    echo "দুঃখিত, আপনার পাসওয়ার্ডটি ম্যাচ হয়নি";
}
 else {
     echo "";
    //echo "<font style='color: green;'>পাসওয়ার্ড সঠিক</font>";
}
?>