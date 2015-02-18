<?php
error_reporting(0);
include_once 'ConnectDB.inc';
 $g_username = $_GET['strkey'];
$cfs_query = mysql_query("SELECT * FROM cfs_user WHERE user_name= '$g_username'");
$y = mysql_num_rows($cfs_query);
if($y > 0)
{
    echo "দুঃখিত, আপনার ইউজার নামটি ইতোমধ্যে ব্যবহৃত হয়েছে";
}
 else {
    echo "";
}
?>